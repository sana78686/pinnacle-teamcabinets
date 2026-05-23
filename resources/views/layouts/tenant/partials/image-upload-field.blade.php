@php
    $field = $name ?? 'image';
    $inputId = $id ?? $field;
    $labelText = $label ?? null;
    $acceptAttr = $accept ?? 'image/*';
    $hint = $hint ?? null;
    $previewUrl = $previewUrl ?? null;
    $previewClass = $previewClass ?? 'tc-settings-preview-img';
    $wrapperClass = $wrapperClass ?? 'tc-field';
@endphp

<div class="{{ $wrapperClass }} tc-image-upload" data-tc-image-upload>
    @if ($labelText)
        <label for="{{ $inputId }}">{{ $labelText }}</label>
    @endif

    <input type="hidden" name="remove_{{ $field }}" value="0" data-tc-image-remove-flag>

    @if ($previewUrl)
        <div class="tc-image-upload__preview" data-tc-image-preview>
            <img src="{{ $previewUrl }}" alt="" class="{{ $previewClass }}">
            <button type="button" class="btn btn-outline-danger btn-sm tc-image-upload__remove" data-tc-image-remove>
                Remove image
            </button>
        </div>
    @endif

    <input
        type="file"
        name="{{ $field }}"
        id="{{ $inputId }}"
        class="form-control {{ $inputClass ?? '' }}"
        accept="{{ $acceptAttr }}"
        @if (!empty($required)) required @endif
    >

    @if ($hint)
        <small class="text-muted d-block mt-1">{{ $hint }}</small>
    @endif
</div>
