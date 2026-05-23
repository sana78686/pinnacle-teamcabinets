/**
 * Adds visible (i) tooltips on tenant form labels for all inputs in <form>.
 * Uses data-tip / title on the field, config map, placeholder, or label text.
 */
(function () {
    'use strict';

    var TIPS = window.TENANT_FIELD_TIPS || {};
    var SKIP_TYPES = { hidden: 1, submit: 1, button: 1, image: 1, reset: 1, file: 0 };

    function fieldKey(el) {
        var name = el.getAttribute('name') || '';
        if (!name) {
            return el.id || '';
        }
        var base = name.replace(/\[\]$/, '').replace(/\[[^\]]+\]/g, '');
        return base || name;
    }

    function tipForField(el) {
        if (el.getAttribute('data-tip')) {
            return el.getAttribute('data-tip');
        }
        var title = el.getAttribute('title');
        if (title) {
            return title;
        }
        var key = fieldKey(el);
        var entry = (key && TIPS[key]) || (el.name && TIPS[el.name]) || (el.id && TIPS[el.id]) || null;
        if (entry) {
            return typeof entry === 'string' ? entry : (entry.text || entry.tip || null);
        }
        var placeholder = el.getAttribute('placeholder');
        if (placeholder && placeholder.length > 2) {
            return placeholder.charAt(0).toUpperCase() + placeholder.slice(1) + '.';
        }
        return null;
    }

    function labelText(anchor) {
        var clone = anchor.cloneNode(true);
        var tips = clone.querySelectorAll('.tc-tip');
        for (var i = 0; i < tips.length; i++) {
            tips[i].remove();
        }
        var req = clone.querySelectorAll('.txt-danger, .asterisk, .pn-req, .text-danger');
        for (var j = 0; j < req.length; j++) {
            req[j].remove();
        }
        return (clone.textContent || '').replace(/\s+/g, ' ').trim();
    }

    function inferFromLabel(anchor) {
        var text = labelText(anchor);
        if (!text || text.length < 2) {
            return null;
        }
        return 'Enter or select a value for ' + text + '.';
    }

    function findPreviousLabel(el) {
        var node = el.previousElementSibling;
        while (node) {
            if (node.tagName === 'LABEL' && !node.classList.contains('form-check-label')) {
                return node;
            }
            if (node.tagName === 'STRONG') {
                return node;
            }
            if (node.tagName === 'BR' || node.tagName === 'IMG' || node.tagName === 'SPAN') {
                node = node.previousElementSibling;
                continue;
            }
            break;
        }
        return null;
    }

    function findLabelAnchor(el) {
        var prev = findPreviousLabel(el);
        if (prev) {
            return prev;
        }

        var fg = el.closest(
            '.form-group, .tc-field, ' +
            '[class*="col-md-"], [class*="col-lg-"], [class*="col-sm-"], [class*="col-xs-"], .mb-3, .p-2'
        );
        if (!fg) {
            return null;
        }
        var id = el.id;
        if (id) {
            try {
                var byFor = fg.querySelector('label[for="' + CSS.escape(id) + '"]');
                if (byFor && !byFor.classList.contains('form-check-label')) {
                    return byFor;
                }
            } catch (e) {
                var byForLegacy = fg.querySelector('label[for="' + id + '"]');
                if (byForLegacy && !byForLegacy.classList.contains('form-check-label')) {
                    return byForLegacy;
                }
            }
        }
        var strong = fg.querySelector(':scope > strong');
        if (strong) {
            return strong;
        }
        var label = fg.querySelector(':scope > label:not(.form-check-label)');
        if (label) {
            return label;
        }
        if (fg.matches('[class*="col-"]')) {
            var colLabel = fg.querySelector('label:not(.form-check-label)');
            if (colLabel) {
                return colLabel;
            }
        }
        if (el.type === 'checkbox' || el.type === 'radio') {
            var checkLabel = fg.querySelector('label.form-check-label');
            if (checkLabel) {
                return checkLabel;
            }
        }
        return null;
    }

    function tipPlacementForField(el) {
        var placement = el.getAttribute('data-tip-placement');
        if (placement) {
            return placement;
        }
        var key = fieldKey(el);
        var entry = (key && TIPS[key]) || (el.name && TIPS[el.name]) || (el.id && TIPS[el.id]) || null;
        if (entry && typeof entry === 'object' && entry.placement) {
            return entry.placement;
        }
        return 'top';
    }

    function createTip(text, placement) {
        var span = document.createElement('span');
        span.className = 'tc-tip';
        span.setAttribute('data-tip', text);
        span.setAttribute('data-placement', placement || 'top');
        span.setAttribute('tabindex', '0');
        span.setAttribute('role', 'button');
        span.setAttribute('aria-label', text);
        span.innerHTML = '<i>i</i>';
        return span;
    }

    function disposeBootstrapTooltip(el) {
        if (typeof jQuery === 'undefined') {
            return;
        }
        var $el = jQuery(el);
        if ($el.data('bs.tooltip')) {
            try {
                $el.tooltip('dispose');
            } catch (e) { /* ignore */ }
        }
    }

    function processField(el) {
        if (el.disabled) {
            return;
        }
        if (SKIP_TYPES[el.type] === 1) {
            return;
        }
        if (el.closest('[data-no-field-tips]')) {
            return;
        }
        if (el.classList.contains('tc-tip-skip')) {
            return;
        }

        var anchor = findLabelAnchor(el);
        if (!anchor) {
            return;
        }
        if (anchor.querySelector('.tc-tip')) {
            return;
        }

        var tip = tipForField(el) || inferFromLabel(anchor);
        if (!tip) {
            return;
        }

        anchor.appendChild(createTip(tip, tipPlacementForField(el)));
        el.removeAttribute('title');
        el.removeAttribute('data-toggle');
        el.removeAttribute('data-bs-toggle');
        el.classList.add('tc-tip-field');
        disposeBootstrapTooltip(el);
    }

    function processForm(form) {
        var fields = form.querySelectorAll('input, select, textarea');
        for (var i = 0; i < fields.length; i++) {
            processField(fields[i]);
        }
    }

    function init(root) {
        var scope = root || document;
        var forms = scope.querySelectorAll('form');
        for (var i = 0; i < forms.length; i++) {
            if (forms[i].closest('.tc-settings-panel, .tc-form-page, .page-body')) {
                processForm(forms[i]);
            }
        }
    }

    function boot() {
        init();
        var panel = document.querySelector('.tc-settings-panel');
        if (panel) {
            window.setTimeout(function () {
                init(panel);
            }, 400);
        }
    }

    if (typeof jQuery !== 'undefined') {
        jQuery(boot);
    } else if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    window.TenantFieldTips = {
        refresh: function (root) {
            var panel = root || document.querySelector('.tc-settings-panel');
            if (panel) {
                init(panel);
                window.setTimeout(function () {
                    init(panel);
                }, 450);
                return;
            }
            init(root);
        },
    };
})();
