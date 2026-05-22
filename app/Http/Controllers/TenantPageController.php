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
        $pages = Page::with('parent')->orderBy('order_no')->paginate(tenant_list_per_page())->withQueryString();

        return view('frontend.index', compact('pages'));
    }

    public function create(Request $request)
    {
        $parents = Page::whereNull('parent_id')->pluck('title', 'id');
        $blogPage = $this->storefrontPages->ensureBlogPage();
        $defaultParentId = $request->query('parent') === 'blog' ? $blogPage->id : $request->query('parent_id');

        return view('frontend.create', compact('parents', 'blogPage', 'defaultParentId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,slug',
        ]);

        Page::create($request->all());

        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        $parents = Page::whereNull('parent_id')->where('id', '!=', $page->id)->pluck('title', 'id');

        return view('frontend.edit', compact('page', 'parents'));
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
        $posts = $blogPage->children()->orderByDesc('created_at')->get();

        return view('frontend.blog_manage', compact('blogPage', 'posts'));
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
        $settings = SiteSetting::first();
        $doorstyles = DoorColors::query()->where('status', 1)->get();
        $catalogs = ProductCatalog::query()
            ->where('status', 1)
            ->with(['doorColors' => fn ($q) => $q->where('status', 1)])
            ->orderBy('name')
            ->get();
        $homesettings = HomeSetting::first();

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
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,slug,'.$page->id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|max:4096',
        ]);

        $data = $request->except(['og_image', '_token', '_method']);

        if ($request->hasFile('og_image')) {
            $dir = public_path('uploads/og');
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $file = $request->file('og_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move($dir, $filename);
            $data['og_image'] = 'uploads/og/'.$filename;
        }

        $page->update($data);

        return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted.');
    }
}
