/**
 * Settings hub: auto placeholders + select empty options from labels.
 */
(function () {
    'use strict';

    function cleanLabelText(text) {
        return (text || '').replace(/\*/g, '').replace(/\s+/g, ' ').trim();
    }

    function labelTextFromEl(label) {
        if (!label) {
            return '';
        }
        var clone = label.cloneNode(true);
        var tips = clone.querySelectorAll('.tc-tip');
        for (var i = 0; i < tips.length; i++) {
            tips[i].remove();
        }
        return cleanLabelText(clone.textContent);
    }

    function findLabel(input) {
        var prev = input.previousElementSibling;
        while (prev) {
            if (prev.tagName === 'LABEL' && !prev.classList.contains('form-check-label')) {
                return prev;
            }
            if (prev.tagName === 'STRONG') {
                return prev;
            }
            if (prev.tagName === 'BR' || prev.tagName === 'IMG' || prev.tagName === 'SPAN') {
                prev = prev.previousElementSibling;
                continue;
            }
            break;
        }
        var wrap = input.closest('.form-group, .mb-3, .tc-field, [class*="col-"]');
        if (!wrap) {
            return null;
        }
        return wrap.querySelector('label:not(.form-check-label), :scope > strong');
    }

    function placeholderFor(labelText, input) {
        if (!labelText) {
            return '';
        }
        var lower = labelText.toLowerCase();
        if (input.type === 'email') {
            return 'Enter ' + lower;
        }
        if (input.type === 'url') {
            return 'https://example.com/' + lower.replace(/\s+/g, '-');
        }
        if (input.type === 'tel') {
            return 'Enter ' + lower;
        }
        if (input.type === 'number') {
            return 'Enter ' + lower;
        }
        return 'Enter ' + lower;
    }

    function enhanceSelect(select) {
        if (select.classList.contains('tc-placeholder-skip')) {
            return;
        }
        var first = select.options[0];
        if (first && first.value === '') {
            first.textContent = first.textContent || '-- Select --';
            first.disabled = true;
            first.hidden = false;
            return;
        }
        if (select.value === '' && select.querySelector('option[value=""]')) {
            return;
        }
    }

    function apply(root) {
        if (!root) {
            return;
        }

        var inputs = root.querySelectorAll(
            'input.form-control:not([type=file]):not([type=checkbox]):not([type=radio]):not([type=hidden]), ' +
            'textarea.form-control'
        );
        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            if (input.placeholder && input.placeholder.trim()) {
                continue;
            }
            if (input.id === 'editor' || input.closest('.ck-editor')) {
                continue;
            }
            var label = findLabel(input);
            var text = labelTextFromEl(label);
            if (!text) {
                continue;
            }
            input.placeholder = placeholderFor(text, input);
        }

        var selects = root.querySelectorAll('select.form-control, select.form-select');
        for (var j = 0; j < selects.length; j++) {
            enhanceSelect(selects[j]);
        }
    }

    function boot() {
        var panel = document.querySelector('.tc-settings-panel');
        if (!panel) {
            return;
        }
        apply(panel);
    }

    if (typeof jQuery !== 'undefined') {
        jQuery(boot);
    } else if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    window.TenantSettingsForms = { refresh: apply };
})();
