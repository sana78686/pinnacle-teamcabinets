/**
 * TinyMCE GPL — shared init for CMS / home settings rich text fields.
 */
(function () {
    'use strict';

    var pending = [];

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

    function readStoredHeight(key, fallback) {
        try {
            var stored = parseInt(localStorage.getItem(key), 10);
            if (!isNaN(stored) && stored >= 220 && stored <= 900) {
                return stored;
            }
        } catch (e) {}
        return fallback;
    }

    function initEditor(editorId, options) {
        options = options || {};
        var defaultHeight = parseInt(options.height, 10) || 280;
        var heightKey = 'tc_cms_editor_height_' + editorId;
        var startHeight = readStoredHeight(heightKey, defaultHeight);

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
            height: startHeight,
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
                    applyEditorHeight(editor, startHeight);
                });
            },
        });

        var slider = document.getElementById(editorId + '_height');
        var heightLabel = document.getElementById(editorId + '_height_val');
        if (slider) {
            slider.value = String(startHeight);
        }
        if (heightLabel) {
            heightLabel.textContent = startHeight + 'px';
        }
        if (slider) {
            slider.addEventListener('input', function () {
                var h = parseInt(slider.value, 10);
                if (heightLabel) {
                    heightLabel.textContent = h + 'px';
                }
                try {
                    localStorage.setItem(heightKey, String(h));
                } catch (e) {}
                applyEditorHeight(tinymce.get(editorId), h);
            });
        }

        var textarea = document.getElementById(editorId);
        if (textarea) {
            var form = textarea.closest('form');
            if (form && !form.dataset.tcCmsEditorBound) {
                form.dataset.tcCmsEditorBound = '1';
                form.addEventListener('submit', function () {
                    if (typeof tinymce !== 'undefined') {
                        tinymce.triggerSave();
                    }
                });
            }
        }
    }

    function bootPending() {
        while (pending.length) {
            var item = pending.shift();
            initEditor(item.id, item.options);
        }
    }

    window.TcCmsRichEditor = {
        init: function (editorId, options) {
            if (typeof tinymce === 'undefined') {
                pending.push({ id: editorId, options: options || {} });
                return;
            }
            initEditor(editorId, options || {});
        },
        boot: bootPending,
    };

    document.addEventListener('DOMContentLoaded', function () {
        bootPending();
    });
})();
