/**
 * Normalizes legacy settings forms: grid columns, labels, stacked fields.
 */
(function () {
    'use strict';

    var FULL_WIDTH_SELECTORS = 'textarea, [type="file"], .ck-editor, #editor, .col-12';

    function ensureFormClass(form) {
        form.classList.add('tc-settings-form');
    }

    function strongToLabel(root) {
        root.querySelectorAll('.form-group strong').forEach(function (strong) {
            if (strong.closest('label')) {
                return;
            }
            var label = document.createElement('label');
            label.className = 'form-label';
            label.innerHTML = strong.innerHTML;
            strong.replaceWith(label);
        });
        root.querySelectorAll('.form-group').forEach(function (group) {
            group.classList.add('tc-field');
        });
    }

    function isSubmitCol(el) {
        return el.classList.contains('tc-settings-form-actions')
            || (el.classList.contains('col-12') && el.querySelector('button[type="submit"], button:not([type])'));
    }

    function normalizeColumn(col) {
        if (isSubmitCol(col)) {
            col.classList.remove('col-xs-12', 'col-sm-12', 'col-md-12', 'text-center', 'p-2');
            col.classList.add('col-12', 'tc-settings-form-actions');
            return;
        }

        col.classList.remove(
            'col-xs-6', 'col-sm-6', 'col-md-6', 'col-lg-4', 'col-lg-6', 'col-lg-8',
            'p-2', 'm-3'
        );

        var hasWide = col.querySelector('textarea, [type="file"], .ck-editor, #editor');
        if (hasWide || col.classList.contains('col-12')) {
            col.classList.add('col-12');
            return;
        }

        if (!col.classList.contains('col-md-4')
            && !col.classList.contains('col-md-6')
            && !col.classList.contains('col-md-8')) {
            col.classList.add('col-md-4');
        }
    }

    function normalizeRows(root) {
        root.querySelectorAll('.row').forEach(function (row) {
            if (!row.classList.contains('g-3')) {
                row.classList.add('g-3');
            }
            if (!row.classList.contains('tc-settings-form-row')) {
                row.classList.add('tc-settings-form-row');
            }
            row.querySelectorAll(':scope > [class*="col-"]').forEach(normalizeColumn);
        });
    }

    function wrapGroupsInRow(groups, parent, referenceNode) {
        if (!groups.length) {
            return;
        }

        var row = document.createElement('div');
        row.className = 'row g-3 tc-settings-form-row tc-settings-auto-row';
        parent.insertBefore(row, referenceNode);

        groups.forEach(function (group) {
            var col = document.createElement('div');
            var wide = group.querySelector('textarea, [type="file"], #editor');
            col.className = wide ? 'col-12' : 'col-md-4';
            group.classList.add('tc-field');
            col.appendChild(group);
            row.appendChild(col);
        });
    }

    function wrapStackedGroups(form) {
        if (form.querySelector('.tc-settings-section')) {
            return;
        }
        var groups = [];
        var nodes = Array.from(form.childNodes);

        nodes.forEach(function (node) {
            if (node.nodeType !== 1) {
                return;
            }
            if (node.classList.contains('form-group')) {
                groups.push(node);
                return;
            }
            if (groups.length) {
                wrapGroupsInRow(groups, form, node);
                groups = [];
            }
        });

        if (groups.length) {
            wrapGroupsInRow(groups, form, null);
        }
    }

    function wrapOrphanRows(panel) {
        Array.from(panel.children).forEach(function (child) {
            if (child.nodeType !== 1) {
                return;
            }
            if (child.tagName === 'FORM') {
                return;
            }
            if (child.classList.contains('row')
                || child.classList.contains('alert')
                || child.classList.contains('tc-settings-toolbar')) {
                if (child.classList.contains('row') && !child.closest('form')) {
                    var form = document.createElement('form');
                    form.className = 'tc-settings-form';
                    form.method = 'post';
                    panel.insertBefore(form, child);
                    form.appendChild(child);
                }
            }
        });
    }

    function layoutForm(form) {
        if (form.dataset.tcLayoutDone === '1') {
            normalizeRows(form);
            return;
        }
        ensureFormClass(form);
        strongToLabel(form);
        wrapStackedGroups(form);
        normalizeRows(form);
        form.dataset.tcLayoutDone = '1';
    }

    function layoutPanel(panel) {
        if (!panel) {
            return;
        }
        wrapOrphanRows(panel);
        panel.querySelectorAll('form').forEach(layoutForm);
        strongToLabel(panel);
        normalizeRows(panel);
    }

    function boot() {
        layoutPanel(document.querySelector('.tc-settings-panel'));
    }

    if (typeof jQuery !== 'undefined') {
        jQuery(boot);
    } else if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    window.TenantSettingsLayout = { refresh: layoutPanel };
})();
