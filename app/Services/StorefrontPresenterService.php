<?php

namespace App\Services;

use App\Models\HomeSetting;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class StorefrontPresenterService
{
    public function site(): ?SiteSetting
    {
        if (! tenant('id')) {
            return SiteSetting::query()->first();
        }

        return SiteSetting::forCurrentTenant();
    }

    public function homeSettings(): ?HomeSetting
    {
        if (! tenant('id')) {
            return HomeSetting::query()->first();
        }

        return HomeSetting::forCurrentTenant();
    }

    public function publicAsset(?string $path): ?string
    {
        if ($path === null || trim($path) === '') {
            return null;
        }

        return tenant_media_url($path);
    }

    public function companyName(): string
    {
        return (string) (tenant('company_name') ?? tenant('name') ?? config('app.name'));
    }

    /**
     * @return array{title: string, description: string, keywords: string, canonical: string, og_title: string, og_description: string, og_image: ?string, og_type: string, twitter_card: string}
     */
    public function seo(
        ?string $title = null,
        ?string $description = null,
        ?string $keywords = null,
        ?string $canonical = null,
        ?string $ogImage = null,
        string $ogType = 'website',
    ): array {
        $site = $this->site();
        $company = $this->companyName();
        $defaultTitle = $site?->site_meta_title ?: ($company.' — Wholesale RTA Cabinets');
        $defaultDescription = $site?->site_meta_description
            ?: 'Wholesale RTA cabinets for dealers, showrooms, and contractors.';
        $defaultKeywords = $site?->site_meta_keywords ?: 'RTA cabinets, wholesale, kitchen cabinets';
        $defaultOg = $this->publicAsset($ogImage ?? $site?->og_image ?? $site?->logo);

        $resolvedTitle = $title ?: $defaultTitle;
        if ($title && ! str_contains($title, $company)) {
            $resolvedTitle = $title.' — '.$company;
        }

        return [
            'title' => $resolvedTitle,
            'description' => Str::limit(strip_tags($description ?: $defaultDescription), 300, ''),
            'keywords' => $keywords ?: $defaultKeywords,
            'canonical' => $canonical ?: url()->current(),
            'og_title' => $title ?: $defaultTitle,
            'og_description' => Str::limit(strip_tags($description ?: $defaultDescription), 300, ''),
            'og_image' => $defaultOg,
            'og_type' => $ogType,
            'twitter_card' => 'summary_large_image',
        ];
    }

    public function homeSeo(): array
    {
        $home = $this->homeSettings();
        $site = $this->site();

        return $this->seo(
            title: $home?->meta_title ?: ($site?->site_meta_title ?: null),
            description: $home?->meta_description ?: ($site?->site_meta_description ?: null),
            keywords: $home?->meta_keywords ?: ($site?->site_meta_keywords ?: null),
            canonical: route('cms.page'),
        );
    }

    public function pageSeo(Page $page): array
    {
        return $this->seo(
            title: $page->meta_title ?: $page->title,
            description: $page->meta_description,
            keywords: $page->meta_keywords ?? null,
            canonical: route('cms.page', $page->slug),
            ogImage: $page->og_image,
            ogType: 'article',
        );
    }

    public function hasMeaningfulHtml(?string $html): bool
    {
        if ($html === null) {
            return false;
        }

        $text = trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        return mb_strlen($text) >= 20;
    }

    public function pageIsVisible(?Page $page): bool
    {
        if (! $page || $page->status !== 'published') {
            return false;
        }

        return $this->hasMeaningfulHtml($page->content);
    }

    protected function normalizedPlainText(?string $html): string
    {
        if ($html === null) {
            return '';
        }

        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $text) ?? '');
    }

    /**
     * Stock text seeded for admin editing — must not count as live storefront content.
     */
    public function isPlaceholderContent(?string $html, ?string $slug = null): bool
    {
        $text = $this->normalizedPlainText($html);
        if ($text === '') {
            return true;
        }

        $placeholders = [
            'Add your policy content here.',
            'Tell your story here. Edit this page from Website Designing → About Us.',
            'News and updates from our team. Add posts below from Website Designing → Blog.',
            'Reach our team for dealer applications, orders, and project support. Phone, email, and address are configured under Site Settings.',
            'Questions about dealer applications, orders, or project support? Use the form below or contact us directly.',
        ];

        if ($slug !== null && $slug !== '') {
            $legalDefault = config("tenant_storefront.legal_pages.{$slug}.default_content");
            if (is_string($legalDefault) && $legalDefault !== '') {
                $placeholders[] = $this->normalizedPlainText($legalDefault);
            }
        }

        foreach (config('tenant_storefront_pages', []) as $pageDefaults) {
            if (! empty($pageDefaults['content']) && is_string($pageDefaults['content'])) {
                $placeholders[] = $this->normalizedPlainText($pageDefaults['content']);
            }
        }

        foreach ($placeholders as $placeholder) {
            if ($placeholder !== '' && $text === $placeholder) {
                return true;
            }
        }

        return false;
    }

    /** Published page with real (non-placeholder) body content. */
    public function publishedPageShowsOnStorefront(?Page $page, ?string $slug = null): bool
    {
        if (! $page || $page->status !== 'published') {
            return false;
        }

        $resolvedSlug = $slug ?? $page->slug;

        if ($this->isPlaceholderContent($page->content, $resolvedSlug)) {
            return false;
        }

        return $this->hasMeaningfulHtml($page->content);
    }

    public function hasSiteContactDetails(): bool
    {
        $site = $this->site();

        return filled($site?->contactus_email)
            || filled($site?->email)
            || filled($site?->contactus_phone)
            || filled($site?->phone)
            || filled($site?->address)
            || filled($site?->map_embed_url);
    }

    public function homeAboutSectionVisible(): bool
    {
        $home = $this->homeSettings();
        if (! $home) {
            return false;
        }

        return $this->hasMeaningfulHtml(
            ($home->aboutus_title ?? '').' '.($home->aboutus_description ?? '')
        );
    }

    /** @return Collection<int, array{label: string, url: string}> */
    public function menuPages(): Collection
    {
        $reserved = config('tenant_storefront.reserved_slugs', []);

        return Page::query()
            ->where('status', 'published')
            ->whereNull('parent_id')
            ->where('show_in_menu', true)
            ->whereNotIn('slug', $reserved)
            ->orderBy('order_no')
            ->get()
            ->filter(fn (Page $p) => $this->pageIsVisible($p))
            ->map(fn (Page $p) => [
                'label' => $p->title,
                'url' => route('cms.page', $p->slug),
            ])
            ->values();
    }

    /** @return Collection<int, array{label: string, url: string, slug: string}> */
    public function legalNavItems(): Collection
    {
        $items = collect();

        foreach (config('tenant_storefront.legal_pages', []) as $slug => $meta) {
            $page = Page::query()
                ->where('slug', $slug)
                ->where('status', 'published')
                ->first();

            if ($this->publishedPageShowsOnStorefront($page, $slug)) {
                $items->push([
                    'slug' => $slug,
                    'label' => $meta['menu_label'] ?? $meta['title'],
                    'url' => route('cms.page', $slug),
                ]);

                continue;
            }

            $taxKey = $meta['tax_key'] ?? '';
            if ($taxKey !== '') {
                $html = tax_value($taxKey, '');
                if ($this->hasMeaningfulHtml($html)) {
                    $items->push([
                        'slug' => $slug,
                        'label' => $meta['menu_label'] ?? $meta['title'],
                        'url' => route('cms.page', $slug),
                    ]);
                }
            }
        }

        return $items;
    }

    /** @return Collection<int, array{label: string, url: string, slug: string}> */
    public function headerLegalNavItems(): Collection
    {
        return $this->legalNavItems()->filter(function (array $item) {
            $slug = $item['slug'] ?? '';

            return (bool) config("tenant_storefront.legal_pages.{$slug}.in_header", false);
        })->values();
    }

    public function contactPage(): ?Page
    {
        $page = Page::findContactPage();

        return ($page && $page->status === 'published') ? $page : null;
    }

    public function contactPageUrl(): string
    {
        $page = $this->contactPage();

        return $page ? route('cms.page', $page->slug) : route('cms.page', 'contact');
    }

    /** Whether CMS intro HTML should render above the contact form. */
    public function contactShowsIntro(?Page $page): bool
    {
        return $page !== null && $this->publishedPageShowsOnStorefront($page, 'contact');
    }

    public function aboutPage(): ?Page
    {
        $page = Page::findAboutPage();

        return $this->publishedPageShowsOnStorefront($page, Page::SLUG_ABOUT) ? $page : null;
    }

    public function blogPage(): ?Page
    {
        $page = Page::findBlogPage();
        if (! $page || $page->status !== 'published') {
            return null;
        }

        $hasPosts = $page->children()->where('status', 'published')->exists();

        return ($this->pageIsVisible($page) || $hasPosts) ? $page : null;
    }

    public function showContactNav(): bool
    {
        return $this->contactPage() !== null || $this->hasSiteContactDetails();
    }

    public function showAboutNav(): bool
    {
        return $this->aboutPage() !== null || $this->homeAboutSectionVisible();
    }

    public function showBlogNav(): bool
    {
        return $this->blogPage() !== null;
    }

    /**
     * Resolve legal page body HTML (CMS page or tax_values).
     *
     * @return array{title: string, html: string, source: string}|null
     */
    public function resolveLegalPage(string $slug): ?array
    {
        $config = config("tenant_storefront.legal_pages.{$slug}");
        if (! $config) {
            return null;
        }

        $page = Page::query()->where('slug', $slug)->where('status', 'published')->first();
        if ($this->publishedPageShowsOnStorefront($page, $slug)) {
            return [
                'title' => $page->title,
                'html' => (string) $page->content,
                'source' => 'page',
                'page' => $page,
            ];
        }

        $taxKey = $config['tax_key'] ?? '';
        if ($taxKey !== '') {
            $html = tax_value($taxKey, '');
            if ($this->hasMeaningfulHtml($html)) {
                return [
                    'title' => $config['title'],
                    'html' => $html,
                    'source' => 'tax',
                    'page' => null,
                ];
            }
        }

        return null;
    }

    public function isLegalSlug(string $slug): bool
    {
        return array_key_exists($slug, config('tenant_storefront.legal_pages', []));
    }

    public function isContactSlug(string $slug): bool
    {
        return in_array($slug, ['contact', 'contact-us'], true);
    }

    public function isAboutSlug(string $slug): bool
    {
        return in_array($slug, ['about', 'about-us'], true);
    }

    /**
     * @param  array<int, array{label: string, url?: string|null}>  $trail
     * @return array<int, array{label: string, url: ?string}>
     */
    public function breadcrumbs(array $trail): array
    {
        return array_merge([
            ['label' => 'Home', 'url' => route('cms.page')],
        ], $trail);
    }

    /** @return array<int, array{label: string, url: string}> */
    public function footerNavLinks(): array
    {
        $links = [
            ['label' => 'Home', 'url' => route('cms.page')],
        ];

        if ($this->showAboutNav()) {
            $about = $this->aboutPage();
            $links[] = [
                'label' => 'About',
                'url' => $about ? route('cms.page', $about->slug) : route('cms.page', 'about'),
            ];
        }

        $links[] = ['label' => 'Cabinetry', 'url' => route('cms.page').'#hz-catalog-lines'];

        if ($this->showBlogNav() && ($blog = $this->blogPage())) {
            $links[] = ['label' => 'Articles', 'url' => route('cms.page', $blog->slug)];
        }

        if ($this->showContactNav()) {
            $links[] = [
                'label' => 'Contact us',
                'url' => $this->contactPageUrl(),
            ];
        }

        return $links;
    }
}
