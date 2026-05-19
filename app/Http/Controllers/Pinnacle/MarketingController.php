<?php

namespace App\Http\Controllers\Pinnacle;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function home(): View
    {
        return view('pinnacle.home', $this->shared());
    }

    public function services(): View
    {
        return view('pinnacle.services', $this->shared());
    }

    /** @deprecated Use services */
    public function features(): View
    {
        return $this->services();
    }

    public function teamCabinets(): View
    {
        return view('pinnacle.team-cabinets', $this->shared());
    }

    public function contact(): View
    {
        return view('pinnacle.contact', $this->shared());
    }

    public function privacy(): View
    {
        return view('pinnacle.legal.privacy', $this->shared());
    }

    public function terms(): View
    {
        return view('pinnacle.legal.terms', $this->shared());
    }

    public function cookies(): View
    {
        return view('pinnacle.legal.cookies', $this->shared());
    }

    public function subscriptionTerms(): View
    {
        return view('pinnacle.legal.subscription', $this->shared());
    }

    /** @return array<string, mixed> */
    private function shared(): array
    {
        return [
            'pinnacle' => config('pinnacle'),
        ];
    }
}
