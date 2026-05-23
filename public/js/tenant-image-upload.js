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

        if (!removeBtn || !preview || !removeFlag || !fileInput) {
            return;
        }

        removeBtn.addEventListener('click', function () {
            removeFlag.value = '1';
            preview.remove();
            fileInput.value = '';
        });

        fileInput.addEventListener('change', function () {
            if (fileInput.files && fileInput.files.length > 0) {
                removeFlag.value = '0';
            }
        });
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
