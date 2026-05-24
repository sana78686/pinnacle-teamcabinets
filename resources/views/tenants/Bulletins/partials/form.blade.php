@php
    $bulletin = $bulletin ?? null;
    $formAction = $formAction ?? route('tenant_bulletin_store');
@endphp
<form action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="tc-bulletin-form">
    @csrf
    <div class="row g-3">
        <div class="col-md-6 col-lg-4">
            <label class="form-label" for="select_user_send_option">Send to<span class="text-danger"> *</span></label>
            <select name="user_option" id="select_user_send_option" class="form-select" required>
                <option value="">Select audience</option>
                <option value="every_one" @selected(old('user_option', $bulletin->user_option ?? '') === 'every_one')>Every One</option>
                <option value="specific_user" @selected(old('user_option', $bulletin->user_option ?? '') === 'specific_user')>Specific User</option>
            </select>
        </div>
        @include('tenants.Bulletins.partials.target-role-field', [
            'selectedRole' => old('target_role', $bulletin->target_role ?? null),
            'showByDefault' => old('user_option', $bulletin->user_option ?? '') === 'specific_user',
        ])
        <div class="col-md-6 col-lg-4">
            <label class="form-label" for="bulletin_title">Title<span class="text-danger"> *</span></label>
            <input name="bulletin_title" id="bulletin_title" type="text" class="form-control" required
                value="{{ old('bulletin_title', $bulletin->bulletin_title ?? '') }}">
        </div>
        <div class="col-12">
            <label class="form-label" for="bulletin_description">Description<span class="text-danger"> *</span></label>
            <textarea name="bulletin_description" id="bulletin_description" class="form-control" rows="4" required>{{ old('bulletin_description', $bulletin->bulletin_description ?? '') }}</textarea>
        </div>
        <div class="col-md-6 col-lg-5">
            @include('layouts.tenant.partials.image-upload-field', [
                'name' => 'image',
                'id' => 'bulletin_file',
                'label' => 'Image or PDF',
                'accept' => 'image/*,application/pdf,.doc,.docx',
                'wrapperClass' => 'mb-0',
                'currentPath' => $bulletin?->image,
                'previewUrl' => ($bulletin && $bulletin->isImageAttachment()) ? $bulletin->attachmentUrl() : null,
                'mediaType' => ($bulletin && $bulletin->isPdfAttachment()) ? 'pdf' : 'image',
            ])
        </div>
        <div class="col-12 d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-primary">{{ $submitLabel ?? 'Save Bulletin' }}</button>
            <a href="{{ route('tenant_bulletin_index') }}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</form>
