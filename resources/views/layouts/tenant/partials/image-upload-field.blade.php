@php
    use App\Support\PublicUploadedFile;

    $field = $name ?? 'image';
    $inputId = $id ?? $field;
    $urlField = $urlField ?? $field.'_url';
    $urlInputId = $urlInputId ?? $urlField;
    $labelText = $label ?? null;
    $mediaType = $mediaType ?? 'image';
    $acceptAttr = $accept ?? ($mediaType === 'pdf' ? 'application/pdf' : \App\Support\ImageUpload::ACCEPT);
    $hint = $hint ?? ($mediaType === 'pdf' ? \App\Support\MediaUpload::hint(5120, true) : \App\Support\MediaUpload::hint());
    $previewClass = $previewClass ?? 'tc-settings-preview-img';
    $wrapperClass = $wrapperClass ?? 'tc-field';
    $currentPath = $currentPath ?? null;

    if (! isset($previewUrl) && $currentPath && $mediaType === 'image') {
        $previewUrl = tenant_media_url($currentPath);
    }

    $urlValue = old($urlField, PublicUploadedFile::isExternalUrl($currentPath) ? $currentPath : '');
    $showImagePreview = $mediaType === 'image' && ! empty($previewUrl);
    $showPdfPreview = $mediaType === 'pdf' && filled($currentPath);
    $pdfHref = null;
    if ($showPdfPreview) {
        $pdfHref = PublicUploadedFile::isExternalUrl($currentPath)
            ? $currentPath
            : ($pdfViewRoute ?? tenant_media_url($currentPath));
    }
@endphp

<div class="{{ $wrapperClass }} tc-image-upload" data-tc-image-upload>
    @if ($labelText)
        <label for="{{ $inputId }}">{{ $labelText }}</label>
    @endif

    <input type="hidden" name="remove_{{ $field }}" value="0" data-tc-image-remove-flag>

    @if ($showImagePreview || $showPdfPreview)
        <div class="tc-image-upload__preview" data-tc-image-preview>
            @if ($showImagePreview)
                <img src="{{ $previewUrl }}" alt="" class="{{ $previewClass }}">
            @elseif ($showPdfPreview && $pdfHref)
                <a href="{{ $pdfHref }}" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener">View PDF</a>
            @endif
            <button type="button" class="btn btn-outline-danger btn-sm tc-image-upload__remove" data-tc-image-remove>
                Remove {{ $mediaType === 'pdf' ? 'PDF' : 'image' }}
            </button>
        </div>
    @endif

    <input
        type="file"
        name="{{ $field }}"
        id="{{ $inputId }}"
        class="form-control {{ $inputClass ?? '' }}"
        accept="{{ $acceptAttr }}"
    >

    <div class="tc-image-upload__url mt-2">
        <label for="{{ $urlInputId }}" class="form-label small text-muted mb-1">Or paste a direct link</label>
        <input
            type="url"
            name="{{ $urlField }}"
            id="{{ $urlInputId }}"
            class="form-control form-control-sm"
            value="{{ $urlValue }}"
            placeholder="{{ $mediaType === 'pdf' ? 'https://example.com/catalog.pdf' : 'https://example.com/image.webp' }}"
            data-tc-media-url
            inputmode="url"
            autocomplete="off"
        >
    </div>

    @if ($hint)
        <small class="text-muted d-block mt-1">{{ $hint }}</small>
    @endif
</div>
