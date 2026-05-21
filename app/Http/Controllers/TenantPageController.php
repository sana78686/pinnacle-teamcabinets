<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DoorColors;
use App\Models\HomeSetting;
use App\Models\Page;
use App\Models\ProductCatalog;
use App\Models\SiteSetting;
use App\Services\StorefrontPageService;
use App\Services\TenantFrontendThemeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantPageController extends Controller
{
    public function __construct(
        protected TenantFrontendThemeService $themes,
        protected StorefrontPageService $storefrontPages,
    ) {}

    public function index()
    {
        $pages = Page::with('parent')->orderBy('order_no')->paginate(10);

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
            return view($this->themes->view('home'), $this->homePayload());
        }

        $page = Page::with('parent')->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $doorstyles = DoorColors::query()->where('status', 1)->get();
        $settings = SiteSetting::first();
        $settingsCompleted = $settings && $settings->logo && $settings->phone && $settings->email && $settings->address;
        $contactPage = Page::findContactPage();
        $aboutPage = Page::findAboutPage();
        $blogPage = Page::findBlogPage();

        if ($page->isBlogIndex()) {
            $posts = $page->children()
                ->where('status', 'published')
                ->orderByDesc('created_at')
                ->get();

            return view($this->themes->view('blog'), compact(
                'page',
                'posts',
                'settings',
                'settingsCompleted',
                'doorstyles',
                'contactPage',
                'aboutPage',
                'blogPage'
            ));
        }

        return view($this->themes->view('page'), compact(
            'page',
            'settings',
            'settingsCompleted',
            'doorstyles',
            'contactPage',
            'aboutPage',
            'blogPage'
        ));
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

    /** @return array<string, mixed> */
    protected function homePayload(): array
    {
        $pages = Page::with('parent')->orderBy('order_no')->paginate(10);
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
        ]);

        $page->update($request->all());

        return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted.');
    }
}
