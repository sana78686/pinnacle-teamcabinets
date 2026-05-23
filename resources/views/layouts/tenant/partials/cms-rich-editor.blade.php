{{-- Rich text editor (TinyMCE GPL). Include multiple times per form; script loads once. --}}
@php
    $editorId = $editorId ?? 'editor';
    $editorHeight = (int) ($editorHeight ?? 280);
    $fieldName = $name ?? 'content';
    $tips = config('tenant_field_tips', []);
    $tipEntry = $tip ?? ($tips[$fieldName] ?? ($tips[$editorId] ?? null));
    $tipText = is_array($tipEntry) ? ($tipEntry['text'] ?? null) : $tipEntry;
    $tipPlacement = $tipPlacement ?? (is_array($tipEntry) ? ($tipEntry['placement'] ?? 'top') : 'top');
@endphp

<div class="tc-cms-editor-field mb-3 tc-field" data-no-field-tips>
    <div class="tc-cms-editor-field__head d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
        <label for="{{ $editorId }}" class="form-label mb-0 d-inline-flex align-items-center flex-wrap">
            {{ $label ?? 'Page Content' }}
            @if ($tipText)
                <span class="tc-tip" data-tip="{{ $tipText }}" data-placement="{{ $tipPlacement }}" tabindex="0" role="button" aria-label="{{ $tipText }}"><i>i</i></span>
            @endif
        </label>
        <div class="tc-cms-editor-field__size d-flex align-items-center gap-2">
            <label for="{{ $editorId }}_height" class="form-label mb-0 small text-muted d-inline-flex align-items-center">
                Editor height
                <span class="tc-tip ms-1" data-tip="Drag to change how tall the editor is. Your choice is saved in this browser." data-placement="left" tabindex="0" role="button" aria-label="Editor height help"><i>i</i></span>
            </label>
            <input type="range" id="{{ $editorId }}_height" class="form-range tc-cms-editor-field__range"
                min="220" max="900" step="20" value="{{ $editorHeight }}" aria-label="Adjust editor height">
            <span class="small text-muted tc-cms-editor-field__height-val" id="{{ $editorId }}_height_val">{{ $editorHeight }}px</span>
        </div>
    </div>
    <textarea name="{{ $fieldName }}" id="{{ $editorId }}" class="form-control tc-cms-editor-field__textarea tc-tip-skip" rows="8">{{ $value ?? '' }}</textarea>
</div>

@once('tc-cms-rich-editor-assets')
    @push('setting_script')
        <script src="https://cdn.jsdelivr.net/npm/tinymce@7.6.0/tinymce.min.js"></script>
        <script src="{{ tenant_static_asset('js/tenant-cms-rich-editor.js') }}?v=2"></script>
    @endpush
@endonce

@push('setting_script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.TcCmsRichEditor) {
            window.TcCmsRichEditor.init(@json($editorId), { height: {{ $editorHeight }} });
        }
    });
</script>
@endpush
