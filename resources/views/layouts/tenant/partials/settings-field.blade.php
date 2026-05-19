@php
    $fieldId = $id ?? $name;
    $fieldType = $type ?? 'text';
    $isRequired = !empty($required);
    $fieldValue = $value ?? old($name, '');
    $fieldPlaceholder = $placeholder ?? ('Enter ' . strtolower(strip_tags($label)));
@endphp

<div class="mb-3 tc-field">
    <label for="{{ $fieldId }}" class="form-label">
        {{ $label }}
        @if ($isRequired)
            <span class="text-danger">*</span>
        @endif
    </label>
    @if ($fieldType === 'textarea')
        <textarea
            name="{{ $name }}"
            id="{{ $fieldId }}"
            class="form-control"
            rows="{{ $rows ?? 4 }}"
            @if ($isRequired) required @endif
            placeholder="{{ $fieldPlaceholder }}"
        >{{ $fieldValue }}</textarea>
    @elseif ($fieldType === 'select')
        <select
            name="{{ $name }}"
            id="{{ $fieldId }}"
            class="form-select"
            @if ($isRequired) required @endif
        >
            {{ $slot }}
        </select>
    @else
        <input
            type="{{ $fieldType }}"
            name="{{ $name }}"
            id="{{ $fieldId }}"
            class="form-control"
            value="{{ $fieldValue }}"
            @if ($isRequired) required @endif
            placeholder="{{ $fieldPlaceholder }}"
        >
    @endif
    @if (!empty($hint))
        <small class="form-text text-muted tc-field-hint">{{ $hint }}</small>
    @endif
</div>
