<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DoorColors;
use App\Models\HomeSetting;
use App\Models\Page;
use App\Models\ProductCatalog;
use App\Models\SiteSetting;
use App\Services\StorefrontPageService;
use App\Services\StorefrontPresenterService;
use App\Services\TenantFrontendThemeService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TenantPageController extends Controller
{
    public function __construct(
        protected TenantFrontendThemeService $themes,
        protected StorefrontPageService $storefrontPages,
        protected StorefrontPresenterService $storefront,
    ) {}

    public function index()
    {
        $pages = Page::query()
            ->panelList()
            ->with('parent')
            ->orderBy('order_no')
            ->orderBy('title')
            ->paginate(tenant_list_per_page())
            ->withQueryString();

        return view('frontend.index', compact('pages'));
    }

    public function create(Request $request)
    {
        if ($request->query('parent') === 'blog') {
            $blogPage = Page::findBlogPage() ?? $this->storefrontPages->ensureBlogPage();

            return view('frontend.create', [
                'parents' => collect(),
                'blogPage' => $blogPage,
                'defaultParentId' => $blogPage->id,
                'isArticle' => true,
            ]);
        }

        $parents = Page::cmsOnly()
            ->whereNull('parent_id')
            ->orderBy('title')
            ->pluck('title', 'id');

        return view('frontend.create', [
            'parents' => $parents,
            'isArticle' => false,
        ]);
    }

    public function store(Request $request)
    {
        $tenantId = tenant('id');
        if (! $tenantId) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tenant context was lost. Refresh the page and try again.');
        }

        $slug = Str::slug((string) $request->input('slug', ''));

        $request->merge(['slug' => $slug]);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Page::class, 'slug')->where(fn ($q) => $q->where('tenant_id', $tenantId)),
            ],
            'content' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'order_no' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|integer|exists:pages,id',
        ]);

        $blog = Page::findBlogPage();
        $isArticleRequest = $request->boolean('is_article') || $request->query('parent') === 'blog';

        if ($slug !== '' && ! $isArticleRequest && ! $request->filled('parent_id') && $this->isReservedTopLevelSlug($slug)) {
            $existing = Page::query()
                ->where('slug', $slug)
                ->whereNull('parent_id')
                ->first();

            if ($existing) {
                if ($existing->isBlogIndex()) {
                    return redirect()
                        ->route('tenant_storefront_blog')
                        ->with('info', 'Manage your blog from Articles.');
                }

                return redirect()
                    ->route('pages.edit', $existing)
                    ->with('info', 'That page already exists. You can edit it here.');
            }
        }

        $parentId = $request->input('parent_id');
        $isArticle = $request->boolean('is_article')
            && $blog
            && (int) $parentId === (int) $blog->id;

        if ($blog && (int) $parentId === (int) $blog->id && ! $isArticle) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['parent_id' => 'Blog posts must be created from Website Designing → Articles.']);
        }

        if (! $isArticle && ! $request->filled('parent_id') && $this->isReservedTopLevelSlug($slug)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['slug' => 'That URL is reserved for a system page (About, Blog, Contact). Use the matching section under Website Designing.']);
        }

        try {
            $page = Page::create(array_merge($request->only((new Page)->getFillable()), [
                'tenant_id' => $tenantId,
                'slug' => $slug,
                'parent_id' => $isArticle ? $blog->id : ($parentId ?: null),
                'order_no' => (int) $request->input('order_no', 0),
                'status' => $request->input('status', 'draft'),
            ]));
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Could not save the page. Please try again.');
        }

        if ($isArticle) {
            return redirect()
                ->route('tenant_storefront_blog')
                ->with('success', 'Article saved successfully.');
        }

        return redirect()
            ->route('pages.index')
            ->with('success', 'Page "'.$page->title.'" created successfully.');
    }

    public function edit(Page $page)
    {
        if ($page->isBlogPost()) {
            return view('frontend.edit', [
                'page' => $page,
                'parents' => collect(),
                'blogPage' => Page::findBlogPage(),
                'isArticle' => true,
            ]);
        }

        $parents = Page::cmsOnly()
            ->whereNull('parent_id')
            ->where('id', '!=', $page->id)
            ->orderBy('title')
            ->pluck('title', 'id');

        return view('frontend.edit', [
            'page' => $page,
            'parents' => $parents,
            'isArticle' => false,
        ]);
    }

    public function show($slug = null)
    {
         if (is_null($slug)) {
            return view($this->themes->view('home'), array_merge($this->homePayload(), [
                'seo' => $this->storefront->homeSeo(),
            ]));
        }

        if ($this->storefront->isLegalSlug($slug)) {
            $legal = $this->storefront->resolveLegalPage($slug);
            if (! $legal) {
                throw new NotFoundHttpException;
            }

            return view($this->themes->view('legal'), [
                'legal' => $legal,
                'hzBreadcrumbs' => $this->storefront->breadcrumbs([
                    ['label' => $legal['title'], 'url' => null],
                ]),
                'seo' => $this->storefront->seo(
                    title: $legal['title'],
                    description: Str::limit(strip_tags($legal['html']), 160),
                    canonical: route('cms.page', $slug),
                ),
            ]);
        }

        if ($this->storefront->isContactSlug($slug)) {
            if (! $this->storefront->showContactNav()) {
                throw new NotFoundHttpException;
            }

            $page = Page::with('parent')->where('slug', $slug)->where('status', 'published')->first()
                ?? $this->storefront->contactPage();

            return view($this->themes->view('contact'), [
                'page' => $page,
                'hzBreadcrumbs' => $this->storefront->breadcrumbs([
                    ['label' => 'Contact', 'url' => null],
                ]),
                'seo' => $page
                    ? $this->storefront->pageSeo($page)
                    : $this->storefront->seo(title: 'Contact us', canonical: route('cms.page', $slug)),
            ]);
        }

        if ($this->storefront->isAboutSlug($slug)) {
            if (! $this->storefront->showAboutNav()) {
                throw new NotFoundHttpException;
            }

            $page = Page::with('parent')->where('slug', $slug)->where('status', 'published')->first()
                ?? $this->storefront->aboutPage();

            return view($this->themes->view('about'), array_merge($this->homePayload(), [
                'page' => $page,
                'hzBreadcrumbs' => $this->storefront->breadcrumbs([
                    ['label' => 'About', 'url' => null],
                ]),
                'seo' => $page && $this->storefront->pageIsVisible($page)
                    ? $this->storefront->pageSeo($page)
                    : $this->storefront->seo(title: 'About us', canonical: route('cms.page', $slug)),
            ]));
        }

        $page = Page::with('parent')->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        if (! $page->isBlogIndex() && ! $this->storefront->pageIsVisible($page)) {
            throw new NotFoundHttpException;
        }

        if ($page->isBlogIndex()) {
            $posts = $page->children()
                ->where('status', 'published')
                ->orderByDesc('created_at')
                ->get();

            return view($this->themes->view('blog'), [
                'page' => $page,
                'posts' => $posts,
                'seo' => $this->storefront->pageSeo($page),
            ]);
        }

        return view($this->themes->view('page'), [
            'page' => $page,
            'hzBreadcrumbs' => $this->pageBreadcrumbs($page),
            'seo' => $this->storefront->pageSeo($page),
        ]);
    }

    public function editAbout(): RedirectResponse
    {
        $page = $this->storefrontPages->ensureAboutPage();

        return redirect()->route('pages.edit', $page->id);
    }

    public function blogManage(): View
    {
        $blogPage = $this->storefrontPages->ensureBlogPage();
        $posts = Page::blogPosts()->orderByDesc('created_at')->get();

        return view('frontend.blog_manage', compact('blogPage', 'posts'));
    }

    protected function isReservedTopLevelSlug(string $slug): bool
    {
        return in_array($slug, Page::reservedTopLevelSlugs(), true);
    }

    /** @return array<int, array{label: string, url: ?string}> */
    protected function pageBreadcrumbs(Page $page): array
    {
        if ($page->isBlogPost() && ($blog = $this->storefront->blogPage())) {
            return $this->storefront->breadcrumbs([
                ['label' => $blog->title, 'url' => route('cms.page', $blog->slug)],
                ['label' => $page->title, 'url' => null],
            ]);
        }

        return $this->storefront->breadcrumbs([
            ['label' => $page->title, 'url' => null],
        ]);
    }

    /** @return array<string, mixed> */
    protected function homePayload(): array
    {
        $pages = Page::with('parent')->orderBy('order_no')->paginate(tenant_list_per_page())->withQueryString();
        $settings = SiteSetting::forCurrentTenant();
        $doorstyles = DoorColors::query()->where('status', 1)->get();
        $catalogs = ProductCatalog::query()
            ->where('status', 1)
            ->with(['doorColors' => fn ($q) => $q->where('status', 1)])
            ->orderBy('name')
            ->get();
        $homesettings = HomeSetting::forCurrentTenant();

        $bennersection = $homesettings
            && $homesettings->banner_image
            && $homesettings->benner_title
            && $homesettings->benner_description
            ? $homesettings
            : null;

        $aboutussection = $homesettings
            && $homesettings->aboutus_image
            && $homesettings->aboutus_title
            && $homesettings->aboutus_description
            ? $homesettings
            : null;

        $cardsection = $homesettings
            && $homesettings->card_one_title
            && $homesettings->card_one_description
            && $homesettings->card_two_title
            && $homesettings->card_two_description
            && $homesettings->card_three_title
            && $homesettings->card_three_description
            ? $homesettings
            : null;

        $settingsCompleted = $settings && $settings->phone && $settings->email;

        $faqs = $homesettings?->resolvedFaqs() ?? config('tenant_hazel_home.faqs', []);
        $contactPage = Page::findContactPage();
        $aboutPage = Page::findAboutPage();
        $blogPage = Page::findBlogPage();

        return compact(
            'pages',
            'settings',
            'settingsCompleted',
            'doorstyles',
            'catalogs',
            'bennersection',
            'aboutussection',
            'cardsection',
            'homesettings',
            'faqs',
            'contactPage',
            'aboutPage',
            'blogPage'
        );
    }

    public function update(Request $request, Page $page)
    {
        $tenantId = tenant('id');
        $slug = Str::slug((string) $request->input('slug', ''));
        $request->merge(['slug' => $slug]);

        $request->validate([
            'title' => 'required',
            'slug' => [
                'required',
                Rule::unique('pages', 'slug')
                    ->where(fn ($q) => $q->where('tenant_id', $tenantId))
                    ->ignore($page->id),
            ],
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:500',
            ...\App\Support\MediaUpload::imageFieldRules('og_image', 4096),
        ]);

        $data = $request->only((new Page)->getFillable());
        $data['slug'] = $slug;
        if (array_key_exists('parent_id', $data) && $data['parent_id'] === '') {
            $data['parent_id'] = null;
        }

        $blog = Page::findBlogPage();
        if ($page->isBlogPost()) {
            $data['parent_id'] = $blog?->id;
        } elseif ($blog && isset($data['parent_id']) && (int) $data['parent_id'] === (int) $blog->id) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['parent_id' => 'Assign blog posts from Website Designing → Articles.']);
        } elseif (! $page->isBlogPost() && ! $request->filled('parent_id') && $this->isReservedTopLevelSlug($slug) && $page->slug !== $slug) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['slug' => 'That URL is reserved for a system page.']);
        }

        $data['og_image'] = \App\Support\PublicUploadedFile::resolve(
            $request,
            'og_image',
            $page->og_image,
            'uploads/og'
        );

        $page->fill($data);
        $page->save();

        if ($page->isBlogPost()) {
            return redirect()
                ->route('tenant_storefront_blog')
                ->with('success', 'Article updated successfully.');
        }

        return redirect()
            ->route('pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        if ($page->isBlogPost()) {
            $page->delete();

            return redirect()
                ->route('tenant_storefront_blog')
                ->with('success', 'Article deleted.');
        }

        if (! $page->isCmsPage()) {
            return redirect()
                ->route('tenant_website_designing')
                ->with('error', 'This page is managed under another Website Designing section.');
        }

        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted.');
    }
}
