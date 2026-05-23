/**
 * Initialize TinyMCE on all .tc-rich-text-editor fields in a form (GPL, no license key).
 */
(function () {
    'use strict';

    var DEFAULT_HEIGHT = 200;

    function initEditors(root) {
        if (typeof tinymce === 'undefined') {
            console.error('TinyMCE is not loaded');
            return;
        }

        var scope = root || document;
        var fields = scope.querySelectorAll('textarea.tc-rich-text-editor');
        if (!fields.length) {
            return;
        }

        fields.forEach(function (field) {
            var id = field.id;
            if (!id || tinymce.get(id)) {
                return;
            }

            var height = parseInt(field.getAttribute('data-editor-height'), 10);
            if (isNaN(height) || height < 120) {
                height = DEFAULT_HEIGHT;
            }

            tinymce.init({
                selector: '#' + id,
                license_key: 'gpl',
                height: height,
                resize: true,
                menubar: false,
                branding: false,
                promotion: false,
                plugins: 'lists link autolink code table autoresize',
                toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link table | removeformat code',
                block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3',
                content_style: 'body { font-family: Segoe UI, system-ui, sans-serif; font-size: 15px; line-height: 1.6; }',
                paste_data_images: false,
                autoresize_bottom_margin: 12,
                min_height: 120,
                max_height: 600,
            });
        });

        var form = fields[0].closest('form');
        if (form && !form.dataset.tcRichTextBound) {
            form.dataset.tcRichTextBound = '1';
            form.addEventListener('submit', function () {
                if (typeof tinymce !== 'undefined') {
                    tinymce.triggerSave();
                }
            });
        }
    }

    function boot() {
        initEditors(document.querySelector('.tc-settings-panel') || document);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    window.TenantRichTextEditors = {
        refresh: function (root) {
            initEditors(root || document.querySelector('.tc-settings-panel') || document);
        },
    };
})();
