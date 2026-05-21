<?php

namespace App\View\Composers;

use App\Services\TenantFrontendThemeService;
use Illuminate\View\View;

class TenantFrontendThemeComposer
{
    public function __construct(
        protected TenantFrontendThemeService $themes,
    ) {}

    public function compose(View $view): void
    {
        $view->with('tcFrontendTheme', $this->themes->active());
    }
}
