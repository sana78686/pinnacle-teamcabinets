<?php

namespace App\View\Composers;

use App\Services\StorefrontBrandCssService;
use App\Services\StorefrontPresenterService;
use Illuminate\View\View;

class StorefrontComposer
{
    public function __construct(
        protected StorefrontPresenterService $storefront,
        protected StorefrontBrandCssService $brandCss,
    ) {}

    public function compose(View $view): void
    {
        $site = $this->storefront->site();

        $view->with([
            'sf' => $this->storefront,
            'settings' => $site,
            'sfCompany' => $this->storefront->companyName(),
            'sfLogoUrl' => $this->storefront->publicAsset($site?->logo),
            'sfFaviconUrl' => $this->storefront->publicAsset($site?->favicon ?? $site?->logo),
            'sfContactPage' => $this->storefront->contactPage(),
            'sfAboutPage' => $this->storefront->aboutPage(),
            'sfBlogPage' => $this->storefront->blogPage(),
            'sfMenuPages' => $this->storefront->menuPages(),
            'sfLegalNav' => $this->storefront->legalNavItems(),
            'sfShowContact' => $this->storefront->showContactNav(),
            'sfShowAbout' => $this->storefront->showAboutNav(),
            'sfShowBlog' => $this->storefront->showBlogNav(),
            'sfFooterNav' => $this->storefront->footerNavLinks(),
            'sfBrandStylesheet' => $this->brandCss->stylesheetUrl(),
        ]);
    }
}
