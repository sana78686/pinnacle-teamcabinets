@extends('layouts.tenant.settings')
@section('title', 'Home Page Settings')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_website_designing') }}">Website Designing</a></li>
    <li class="breadcrumb-item active">Home &amp; FAQ</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

<form class="tc-settings-form" action="{{ route('tenant_home_setting_srore') }}" method="post" enctype="multipart/form-data">
    @csrf

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Main Banner</h3>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="banner_image">Banner Image or Video</label>
                    @if ($settings && $settings->banner_image)
                        <img src="{{ asset($settings->banner_image) }}" alt="Banner" class="tc-settings-preview-img">
                    @endif
                    <input type="file" name="banner_image" id="banner_image" class="form-control">
                </div>
            </div>
            <div class="col-md-8">
                <div class="tc-field">
                    <label for="benner_title">Banner Title</label>
                    <input type="text" name="benner_title" id="benner_title" class="form-control"
                        placeholder="Enter banner title" required
                        value="{{ old('benner_title', $settings->benner_title ?? '') }}">
                </div>
            </div>
            <div class="col-12">
                <div class="tc-field">
                    <label for="benner_description">Banner Description</label>
                    <input type="text" name="benner_description" id="benner_description" class="form-control"
                        placeholder="Enter banner description" required
                        value="{{ old('benner_description', $settings->benner_description ?? '') }}">
                </div>
            </div>
        </div>
    </section>

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">About Us</h3>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="aboutus_image">About Us Image</label>
                    @if ($settings && $settings->aboutus_image)
                        <img src="{{ asset($settings->aboutus_image) }}" alt="About us" class="tc-settings-preview-img">
                    @endif
                    <input type="file" name="aboutus_image" id="aboutus_image" class="form-control">
                </div>
            </div>
            <div class="col-md-8">
                <div class="tc-field">
                    <label for="aboutus_title">About Us Title</label>
                    <input type="text" name="aboutus_title" id="aboutus_title" class="form-control"
                        placeholder="Enter about us title" required
                        value="{{ old('aboutus_title', $settings->aboutus_title ?? '') }}">
                </div>
            </div>
            <div class="col-12">
                <div class="tc-field">
                    <label for="aboutus_description">About Us Description</label>
                    <input type="text" name="aboutus_description" id="aboutus_description" class="form-control"
                        placeholder="Enter about us description" required
                        value="{{ old('aboutus_description', $settings->aboutus_description ?? '') }}">
                </div>
            </div>
        </div>
    </section>

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Feature Cards</h3>

        <h4 class="tc-settings-section__subtitle">Card One</h4>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="card_one_title">Title</label>
                    <input type="text" name="card_one_title" id="card_one_title" class="form-control"
                        placeholder="Enter card title" required
                        value="{{ old('card_one_title', $settings->card_one_title ?? '') }}">
                </div>
            </div>
            <div class="col-md-8">
                <div class="tc-field">
                    <label for="card_one_description">Description</label>
                    <input type="text" name="card_one_description" id="card_one_description" class="form-control"
                        placeholder="Enter card description" required
                        value="{{ old('card_one_description', $settings->card_one_description ?? '') }}">
                </div>
            </div>
        </div>

        <h4 class="tc-settings-section__subtitle">Card Two</h4>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="card_two_title">Title</label>
                    <input type="text" name="card_two_title" id="card_two_title" class="form-control"
                        placeholder="Enter card title" required
                        value="{{ old('card_two_title', $settings->card_two_title ?? '') }}">
                </div>
            </div>
            <div class="col-md-8">
                <div class="tc-field">
                    <label for="card_two_description">Description</label>
                    <input type="text" name="card_two_description" id="card_two_description" class="form-control"
                        placeholder="Enter card description" required
                        value="{{ old('card_two_description', $settings->card_two_description ?? '') }}">
                </div>
            </div>
        </div>

        <h4 class="tc-settings-section__subtitle">Card Three</h4>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="card_three_title">Title</label>
                    <input type="text" name="card_three_title" id="card_three_title" class="form-control"
                        placeholder="Enter card title" required
                        value="{{ old('card_three_title', $settings->card_three_title ?? '') }}">
                </div>
            </div>
            <div class="col-md-8">
                <div class="tc-field">
                    <label for="card_three_description">Description</label>
                    <input type="text" name="card_three_description" id="card_three_description" class="form-control"
                        placeholder="Enter card description" required
                        value="{{ old('card_three_description', $settings->card_three_description ?? '') }}">
                </div>
            </div>
        </div>
    </section>

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Homepage FAQ</h3>
        <p class="tc-field-hint mb-3">These questions appear in the FAQ section on your public storefront (Hazel theme). Leave empty rows out before saving.</p>
        <div id="tc-faq-list" class="tc-faq-list">
            @foreach ($faqs as $index => $faq)
                <div class="tc-faq-row card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <strong class="f-14">FAQ #{{ $index + 1 }}</strong>
                            <button type="button" class="btn btn-outline-danger btn-sm tc-faq-remove" aria-label="Remove FAQ">Remove</button>
                        </div>
                        <div class="tc-field mb-2">
                            <label>Question</label>
                            <input type="text" name="faq_question[]" class="form-control" maxlength="500"
                                value="{{ old('faq_question.'.$index, $faq['q'] ?? '') }}" placeholder="e.g. What does RTA mean?">
                        </div>
                        <div class="tc-field mb-0">
                            <label>Answer</label>
                            <textarea name="faq_answer[]" class="form-control" rows="3" maxlength="5000"
                                placeholder="Answer shown on your website">{{ old('faq_answer.'.$index, $faq['a'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm" id="tc-faq-add">
            <i data-feather="plus" class="tc-btn-icon"></i> Add FAQ
        </button>
    </section>

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Homepage SEO</h3>
        <p class="text-muted small mb-3">Meta tags for your public homepage (overrides site-wide defaults when set).</p>
        <div class="row g-3">
            <div class="col-12">
                <div class="tc-field">
                    <label for="meta_title">Home meta title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control"
                        value="{{ old('meta_title', $settings->meta_title ?? '') }}">
                </div>
            </div>
            <div class="col-12">
                <div class="tc-field">
                    <label for="meta_description">Home meta description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="2">{{ old('meta_description', $settings->meta_description ?? '') }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="tc-field">
                    <label for="meta_keywords">Home meta keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"
                        value="{{ old('meta_keywords', $settings->meta_keywords ?? '') }}">
                </div>
            </div>
        </div>
    </section>

    <div class="tc-settings-form-actions">
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </div>
</form>
@endsection

@section('setting_script')
<script src="{{ tenant_static_asset('js/tenant-website-faqs.js') }}?v=1"></script>
@endsection
