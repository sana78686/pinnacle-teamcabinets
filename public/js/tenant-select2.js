(function ($) {
    if (!$) return;

    function syncSelect2Badge($select) {
        var $container = $select.next('.select2-container');
        if (!$container.length) return;
        var hasValue = !!$select.val();
        $container.toggleClass('tc-has-value', hasValue);
        if (hasValue) {
            var data = $select.select2 ? $select.select2('data') : [];
            var text = (data && data[0] && data[0].text) ? data[0].text : $select.find('option:selected').text();
            $container.find('.select2-selection__rendered').attr('data-badge-label', (text || '').trim());
        } else {
            $container.find('.select2-selection__rendered').removeAttr('data-badge-label');
        }
    }

    $(document).ready(function () {
        $('.tc-form-page select').each(function () {
            var $el = $(this);
            if ($el.data('select2')) {
                syncSelect2Badge($el);
            }
        });

        $(document).on('select2:select select2:clear select2:unselect', '.tc-form-page select', function () {
            syncSelect2Badge($(this));
        });
    });
})(window.jQuery);
