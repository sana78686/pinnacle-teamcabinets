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

    public function ensureDefaults(): void
    {
        if (! tenant('id')) {
            return;
        }

        $this->ensureAboutPage();
        $this->ensureBlogPage();
    }

    /**
     * @param  array<string, mixed>  $extra
     */
    protected function ensurePage(string $slug, string $title, string $content, array $extra = []): Page
    {
        $page = Page::query()->where('slug', $slug)->first();

        if ($page) {
            if (trim((string) $page->content) === '' && trim($content) !== '') {
                $page->update(['content' => $content]);
            }

            return $page;
        }

        return Page::create(array_merge([
            'tenant_id' => tenant('id'),
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'status' => 'published',
            'parent_id' => null,
            'show_in_menu' => false,
            'order_no' => 0,
        ], $extra));
    }
}
