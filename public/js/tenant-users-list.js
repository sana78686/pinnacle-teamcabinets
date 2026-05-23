(function () {
    function debounce(fn, ms) {
        var timer;
        return function () {
            var ctx = this;
            var args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                fn.apply(ctx, args);
            }, ms);
        };
    }

    function buildUrl(base, params) {
        var url = new URL(base, window.location.origin);
        Object.keys(params).forEach(function (key) {
            var val = params[key];
            if (val !== null && val !== undefined && val !== '') {
                url.searchParams.set(key, val);
            } else {
                url.searchParams.delete(key);
            }
        });
        return url.toString();
    }

    function initUsersList(root) {
        if (!root || root.dataset.tcUsersListInit === '1') {
            return;
        }
        root.dataset.tcUsersListInit = '1';

        var listUrl = root.dataset.listUrl;
        var autocompleteUrl = root.dataset.autocompleteUrl;
        var form = root.querySelector('[data-tc-users-list-filter]');
        var searchInput = root.querySelector('[data-tc-users-search-input]');
        var clearBtn = root.querySelector('[data-tc-users-search-clear]');
        var perPageSelect = root.querySelector('[data-tc-users-per-page]');
        var autocompleteList = root.querySelector('[data-tc-users-autocomplete]');
        var tbody = root.querySelector('[data-tc-users-tbody]');
        var paginationWrap = root.querySelector('[data-tc-users-pagination]');
        var countEl = root.querySelector('[data-tc-users-list-count]');
        var loading = false;

        if (!form || !searchInput || !tbody || !listUrl) {
            return;
        }

        function currentParams(overrides) {
            var params = {
                search: searchInput.value.trim(),
                per_page: perPageSelect ? perPageSelect.value : '',
                page: '',
            };
            if (overrides) {
                Object.assign(params, overrides);
            }
            return params;
        }

        function updateCount(meta) {
            if (!countEl || !meta) {
                return;
            }
            if (meta.total > 0) {
                countEl.innerHTML =
                    'Showing <strong>' + meta.from + '–' + meta.to + '</strong> of <strong>' +
                    Number(meta.total).toLocaleString() + '</strong>';
            } else {
                countEl.textContent = 'No records';
            }
        }

        function toggleClear() {
            if (!clearBtn) {
                return;
            }
            clearBtn.classList.toggle('d-none', searchInput.value.trim() === '');
        }

        function hideAutocomplete() {
            if (!autocompleteList) {
                return;
            }
            autocompleteList.hidden = true;
            autocompleteList.innerHTML = '';
            searchInput.setAttribute('aria-expanded', 'false');
        }

        function showAutocomplete(items) {
            if (!autocompleteList) {
                return;
            }
            autocompleteList.innerHTML = '';
            if (!items || !items.length) {
                hideAutocomplete();
                return;
            }
            items.forEach(function (item) {
                var li = document.createElement('li');
                li.className = 'tc-users-autocomplete__item';
                li.setAttribute('role', 'option');
                li.dataset.value = item.value || item.label || '';
                li.innerHTML =
                    '<span class="tc-users-autocomplete__label">' + escapeHtml(item.label || '') + '</span>' +
                    (item.subtitle
                        ? '<span class="tc-users-autocomplete__sub">' + escapeHtml(item.subtitle) + '</span>'
                        : '');
                li.addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    searchInput.value = li.dataset.value;
                    hideAutocomplete();
                    toggleClear();
                    fetchList({ page: 1 });
                });
                autocompleteList.appendChild(li);
            });
            autocompleteList.hidden = false;
            searchInput.setAttribute('aria-expanded', 'true');
        }

        function escapeHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        var fetchAutocomplete = debounce(function () {
            if (!autocompleteUrl) {
                return;
            }
            var q = searchInput.value.trim();
            if (q.length < 2) {
                hideAutocomplete();
                return;
            }
            fetch(buildUrl(autocompleteUrl, { q: q }), {
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(function (r) {
                    return r.json();
                })
                .then(showAutocomplete)
                .catch(function () {
                    hideAutocomplete();
                });
        }, 220);

        function bindRowHandlers() {
            if (window.jQuery) {
                jQuery('[data-toggle="tooltip"]', tbody).tooltip();
            }
            if (typeof window.bindUserListRowActions === 'function') {
                window.bindUserListRowActions(tbody);
            }
        }

        function fetchList(overrides) {
            if (loading) {
                return;
            }
            loading = true;
            root.classList.add('tc-users-list--loading');

            var params = currentParams(overrides || { page: 1 });
            var url = buildUrl(listUrl, params);

            fetch(url, {
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(function (r) {
                    return r.json();
                })
                .then(function (data) {
                    tbody.innerHTML = data.rows || '';
                    if (paginationWrap) {
                        paginationWrap.innerHTML = data.pagination || '';
                    }
                    updateCount(data.meta);
                    bindRowHandlers();
                    if (data.url) {
                        window.history.replaceState({}, '', data.url);
                    }
                })
                .catch(function () {
                    form.submit();
                })
                .finally(function () {
                    loading = false;
                    root.classList.remove('tc-users-list--loading');
                });
        }

        var fetchListDebounced = debounce(function () {
            fetchList({ page: 1 });
        }, 400);

        searchInput.addEventListener('input', function () {
            toggleClear();
            fetchAutocomplete();
            fetchListDebounced();
        });

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                hideAutocomplete();
                fetchList({ page: 1 });
            }
            if (e.key === 'Escape') {
                hideAutocomplete();
            }
        });

        searchInput.addEventListener('blur', function () {
            setTimeout(hideAutocomplete, 150);
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                toggleClear();
                hideAutocomplete();
                fetchList({ page: 1 });
                searchInput.focus();
            });
        }

        if (perPageSelect) {
            perPageSelect.addEventListener('change', function () {
                fetchList({ page: 1 });
            });
        }

        if (paginationWrap) {
            paginationWrap.addEventListener('click', function (e) {
                var link = e.target.closest('a.page-link, a[href*="page="]');
                if (!link || !link.href) {
                    return;
                }
                e.preventDefault();
                try {
                    var page = new URL(link.href).searchParams.get('page') || '1';
                    fetchList({ page: page });
                } catch (err) {
                    window.location.href = link.href;
                }
            });
        }

        bindRowHandlers();
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-tc-users-list]').forEach(initUsersList);
        if (window.feather) {
            feather.replace();
        }
    });

    window.TenantUsersList = { init: initUsersList };
})();
