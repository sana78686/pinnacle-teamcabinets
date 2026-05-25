<?php

namespace App\Services;

use App\Models\Page;

class StorefrontPageService
{
    public function ensureAboutPage(): Page
    {
        return $this->ensurePage(
            Page::SLUG_ABOUT,
            'About Us',
            config('tenant_storefront_pages.about.content', '<p>Tell your story here. Edit this page from Website Designing → About Us.</p>'),
            ['show_in_menu' => false, 'order_no' => 1]
        );
    }

    public function ensureBlogPage(): Page
    {
        return $this->ensurePage(
            Page::SLUG_BLOG,
            'Blog',
            config('tenant_storefront_pages.blog.content', '<p>News and updates from our team. Add posts below from Website Designing → Blog.</p>'),
            ['show_in_menu' => false, 'order_no' => 2]
        );
    }

    public function ensureContactPage(): Page
    {
        $defaultContent = (string) config('tenant_storefront_pages.contact.content', '<p>Questions about dealer applications, orders, or project support? Use the form below or contact us directly.</p>');

        $page = $this->ensurePage(
            'contact',
            'Contact Us',
            $defaultContent,
            ['show_in_menu' => false, 'order_no' => 3, 'status' => 'published']
        );

        $presenter = app(StorefrontPresenterService::class);
        if ($presenter->isPlaceholderContent($page->content, 'contact')) {
            $page->update([
                'content' => $defaultContent,
                'status' => 'published',
            ]);
        }

        return $page->fresh();
    }

    public function ensureLegalPages(): void
    {
        foreach (config('tenant_storefront.legal_pages', []) as $slug => $meta) {
            $this->ensurePage(
                $slug,
                $meta['title'] ?? ucfirst(str_replace('-', ' ', $slug)),
                '',
                ['show_in_menu' => false, 'order_no' => 50, 'status' => 'draft']
            );
        }
    }

    public function ensureDefaults(): void
    {
        if (! tenant('id')) {
            return;
        }

        $this->ensureAboutPage();
        $this->ensureBlogPage();
        $this->ensureContactPage();
        $this->ensureLegalPages();
    }

    /**
     * @param  array<string, mixed>  $extra
     */
    protected function ensurePage(string $slug, string $title, string $content, array $extra = []): Page
    {
        $tenantId = tenant('id');

        $page = Page::firstOrCreate(
            ['tenant_id' => $tenantId, 'slug' => $slug],
            array_merge([
                'title' => $title,
                'content' => $content,
                'status' => 'published',
                'parent_id' => null,
                'show_in_menu' => false,
                'order_no' => 0,
            ], $extra)
        );

        if (trim((string) $page->content) === '' && trim($content) !== '') {
            $page->update(['content' => $content]);
        }

        return $page;
    }
}
