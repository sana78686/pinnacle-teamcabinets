<?php

namespace App\Services;

use App\Models\ManageOtherPageContent;

class ManageOtherPageContentService
{
    /**
     * Fixed success/error pages from legacy CI (manage_other_page_contents).
     * Default copy from team-cabinets database/stage.sql (production Team Cabinets).
     *
     * @return array<int, array{slug: string, title: string, page_content: string}>
     */
    public static function defaultPages(): array
    {
        return [
            [
                'slug' => 'thankyou_page',
                'title' => 'Thank You Page',
                'page_content' => '<h1><strong>THANK YOU FOR YOUR ORDER.</strong></h1>'
                    .'<h2>View your order details by clicking <strong>View Order</strong>.</h2>',
            ],
            [
                'slug' => 'error_page',
                'title' => 'Error Page',
                'page_content' => '<h2><strong>Oops!</strong></h2>'
                    .'<h3>There is a problem that has occurred during your order processing.</h3>'
                    .'<h3>This does not mean that your order has not been processed, you should receive an email for your order.</h3>'
                    .'<h3>Please contact our office if you have not received an email for your order.</h3>'
                    .'<p>Thank you,</p><p>TEAM</p>',
            ],
            [
                'slug' => 'shipping_pop_up',
                'title' => 'Shipping Pop Up Content',
                'page_content' => '<p>Selecting this option will lock your cart, please double check your items before asking for a shipping estimate.</p>'
                    .'<p>If you ready to proceed, please fill out the needed information.</p>'
                    .'<p>Thank you,</p><p>TEAM</p>',
            ],
            [
                'slug' => 'stock_check_approve_pop_up',
                'title' => 'Stock Check Approve Pop Up Content',
                'page_content' => '<p>Welcome to STOCK CHECK, this process may take up to 48hours to confirm our warehouse can fill your order.</p>'
                    .'<p>Once we receive confirmation, you will have 48 hours to act on this STOCK CHECK, after 48 hours, we have to release these items for purchasers.</p>'
                    .'<p>Please inform your clients. If you only need a QUOTE, then please select QUOTE, be sure to manually add Taxes and Shipping costs to assure the accuracy of your estimate. If you need a SHIPPING QUOTE, please feel free to send us your QUOTE, and we will be happy to help your company.</p>'
                    .'<p>Thank you,</p><p>TEAM</p>',
            ],
            [
                'slug' => 'stock_check_shipping_pop_up',
                'title' => 'Stock Check Shipping Pop Up Content',
                'page_content' => '<p>Do you want shipping for stock check?</p>',
            ],
        ];
    }

    public function ensureDefaults(): void
    {
        $tenantId = tenant('id');
        if (! $tenantId) {
            return;
        }

        foreach (self::defaultPages() as $page) {
            $record = ManageOtherPageContent::query()->firstOrCreate(
                ['tenant_id' => $tenantId, 'slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'page_content' => $page['page_content'],
                ]
            );

            if (trim((string) $record->page_content) === '') {
                $record->update([
                    'title' => $page['title'],
                    'page_content' => $page['page_content'],
                ]);
            }
        }
    }

    public function contentForSlug(string $slug): string
    {
        $row = ManageOtherPageContent::query()
            ->where('slug', $slug)
            ->first();

        if ($row && trim((string) $row->page_content) !== '') {
            return $row->page_content;
        }

        foreach (self::defaultPages() as $page) {
            if ($page['slug'] === $slug) {
                return $page['page_content'];
            }
        }

        return '';
    }
}
