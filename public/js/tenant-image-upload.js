(function () {
    function initUploadField(wrapper) {
        if (!wrapper || wrapper.dataset.tcImageUploadInit === '1') {
            return;
        }
        wrapper.dataset.tcImageUploadInit = '1';

        var removeBtn = wrapper.querySelector('[data-tc-image-remove]');
        var preview = wrapper.querySelector('[data-tc-image-preview]');
        var removeFlag = wrapper.querySelector('[data-tc-image-remove-flag]');
        var fileInput = wrapper.querySelector('input[type="file"]');
        var urlInput = wrapper.querySelector('[data-tc-media-url]');

        if (!removeFlag || !fileInput) {
            return;
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', function () {
                removeFlag.value = '1';
                if (preview) {
                    preview.remove();
                }
                fileInput.value = '';
                if (urlInput) {
                    urlInput.value = '';
                }
            });
        }

        fileInput.addEventListener('change', function () {
            if (fileInput.files && fileInput.files.length > 0) {
                removeFlag.value = '0';
                if (urlInput) {
                    urlInput.value = '';
                }
            }
        });

        if (urlInput) {
            urlInput.addEventListener('input', function () {
                if (urlInput.value.trim() !== '') {
                    removeFlag.value = '0';
                }
            });
        }
    }

    function initAll(root) {
        (root || document).querySelectorAll('[data-tc-image-upload]').forEach(initUploadField);
    }

    document.addEventListener('DOMContentLoaded', function () {
        initAll(document);
    });

    window.TenantImageUpload = {
        refresh: initAll,
    };
})();
