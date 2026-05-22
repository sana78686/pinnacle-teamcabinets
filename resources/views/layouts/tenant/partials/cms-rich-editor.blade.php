{{-- Rich text editor for CMS pages (TinyMCE GPL — no license key). --}}
@php
    $editorId = $editorId ?? 'editor';
    $editorHeight = (int) ($editorHeight ?? 420);
@endphp

<div class="tc-cms-editor-field mb-3 tc-field">
    <div class="tc-cms-editor-field__head d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
        <label for="{{ $editorId }}" class="form-label mb-0">{{ $label ?? 'Page Content' }}</label>
        <div class="tc-cms-editor-field__size d-flex align-items-center gap-2">
            <label for="{{ $editorId }}_height" class="form-label mb-0 small text-muted">Editor height</label>
            <input type="range" id="{{ $editorId }}_height" class="form-range tc-cms-editor-field__range"
                min="220" max="900" step="20" value="{{ $editorHeight }}" aria-label="Adjust editor height">
            <span class="small text-muted tc-cms-editor-field__height-val" id="{{ $editorId }}_height_val">{{ $editorHeight }}px</span>
        </div>
    </div>
    <textarea name="{{ $name ?? 'content' }}" id="{{ $editorId }}" class="form-control tc-cms-editor-field__textarea" rows="12">{{ $value ?? '' }}</textarea>
</div>

<script src="https://cdn.jsdelivr.net/npm/tinymce@7.6.0/tinymce.min.js"></script>
<script>
(function () {
    var editorId = @json($editorId);
    var defaultHeight = {{ $editorHeight }};
    var heightKey = 'tc_cms_editor_height_' + editorId;

    function readStoredHeight() {
        try {
            var stored = parseInt(localStorage.getItem(heightKey), 10);
            if (!isNaN(stored) && stored >= 220 && stored <= 900) {
                return stored;
            }
        } catch (e) {}
        return defaultHeight;
    }

    function applyEditorHeight(editor, height) {
        if (!editor || !editor.getContainer) {
            return;
        }
        var container = editor.getContainer();
        var chrome = container.querySelector('.tox-editor-header');
        var chromeH = chrome ? chrome.offsetHeight : 88;
        var area = Math.max(160, height - chromeH);
        container.style.height = height + 'px';
        var iframeWrap = container.querySelector('.tox-edit-area');
        if (iframeWrap) {
            iframeWrap.style.height = area + 'px';
        }
    }

    function initTinyMce(height) {
        if (typeof tinymce === 'undefined') {
            console.error('TinyMCE failed to load');
            return;
        }

        if (tinymce.get(editorId)) {
            tinymce.get(editorId).remove();
        }

        tinymce.init({
            selector: '#' + editorId,
            license_key: 'gpl',
            height: height,
            resize: true,
            menubar: false,
            branding: false,
            promotion: false,
            plugins: 'lists link autolink code table image autoresize',
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | removeformat code',
            block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4',
            content_style: 'body { font-family: Segoe UI, system-ui, sans-serif; font-size: 15px; line-height: 1.6; }',
            paste_data_images: true,
            images_upload_handler: function (blobInfo) {
                return new Promise(function (resolve) {
                    var reader = new FileReader();
                    reader.onload = function () { resolve(reader.result); };
                    reader.readAsDataURL(blobInfo.blob());
                });
            },
            autoresize_bottom_margin: 16,
            min_height: 220,
            max_height: 900,
            setup: function (editor) {
                editor.on('init', function () {
                    applyEditorHeight(editor, height);
                });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        var slider = document.getElementById(editorId + '_height');
        var heightLabel = document.getElementById(editorId + '_height_val');
        var startHeight = readStoredHeight();

        if (slider) {
            slider.value = String(startHeight);
        }
        if (heightLabel) {
            heightLabel.textContent = startHeight + 'px';
        }

        initTinyMce(startHeight);

        if (slider) {
            slider.addEventListener('input', function () {
                var h = parseInt(slider.value, 10);
                if (heightLabel) {
                    heightLabel.textContent = h + 'px';
                }
                try {
                    localStorage.setItem(heightKey, String(h));
                } catch (e) {}
                var editor = tinymce.get(editorId);
                applyEditorHeight(editor, h);
            });
        }

        var form = document.getElementById(editorId).closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                if (tinymce.get(editorId)) {
                    tinymce.triggerSave();
                }
            });
        }
    });
})();
</script>
