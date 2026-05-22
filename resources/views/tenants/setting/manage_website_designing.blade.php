@extends('layouts.tenant.settings')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Website Designing</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

<div class="tc-wd-overview">
    <p class="text-muted mb-3 f-14">
        Manage your public storefront: theme, homepage, FAQs, CMS pages, About Us, Blog, and Contact Us content.
    </p>

    <div class="row">
        <div class="col-md-4 mb-3">
            <a href="{{ route('tenant_frontend_theme') }}" class="tc-wd-card">
                <span class="tc-wd-card__icon"><i data-feather="layout"></i></span>
                <strong>Storefront theme</strong>
                <span class="tc-wd-card__meta">Active: {{ $activeThemeLabel }}</span>
                <span class="tc-wd-card__desc">Hazel (professional) or Classic layout for your dealer website.</span>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('tenant_home_setting_index') }}" class="tc-wd-card">
                <span class="tc-wd-card__icon"><i data-feather="home"></i></span>
                <strong>Home &amp; FAQ</strong>
                <span class="tc-wd-card__meta">{{ $faqCount }} FAQ{{ $faqCount === 1 ? '' : 's' }} on homepage</span>
                <span class="tc-wd-card__desc">Banner, about section, feature cards, and FAQ accordion content.</span>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('pages.index') }}" class="tc-wd-card">
                <span class="tc-wd-card__icon"><i data-feather="file-text"></i></span>
                <strong>CMS pages</strong>
                <span class="tc-wd-card__meta">{{ $pageCount }} page{{ $pageCount === 1 ? '' : 's' }}</span>
                <span class="tc-wd-card__desc">Custom pages only — not blog posts or system pages.</span>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('tenant_storefront_about') }}" class="tc-wd-card">
                <span class="tc-wd-card__icon"><i data-feather="info"></i></span>
                <strong>About Us</strong>
                <span class="tc-wd-card__meta">Dedicated page</span>
                <span class="tc-wd-card__desc">Full About page on your website (separate from the home teaser).</span>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('tenant_storefront_blog') }}" class="tc-wd-card">
                <span class="tc-wd-card__icon"><i data-feather="book-open"></i></span>
                <strong>Articles</strong>
                <span class="tc-wd-card__meta">{{ $articleCount ?? 0 }} post{{ ($articleCount ?? 0) === 1 ? '' : 's' }}</span>
                <span class="tc-wd-card__desc">Blog landing page and news posts (separate from CMS pages).</span>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('tenant_setting_manage_index') }}" class="tc-wd-card">
                <span class="tc-wd-card__icon"><i data-feather="phone"></i></span>
                <strong>Contact Us</strong>
                <span class="tc-wd-card__meta">Storefront page</span>
                <span class="tc-wd-card__desc">Contact details and form content for your portal visitors.</span>
            </a>
        </div>
    </div>
</div>
@endsection
