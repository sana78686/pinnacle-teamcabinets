(function () {
    var root = document.getElementById('tc-panel-search');
    var input = document.getElementById('tc-panel-search-input');
    var list = document.getElementById('tc-panel-search-results');

    if (!root || !input || !list) {
        return;
    }

    var url = root.getAttribute('data-search-url');
    var debounceMs = 100;
    var minChars = 2;
    var timer = null;
    var abortCtrl = null;
    var activeIndex = -1;

    function showResults(show) {
        list.hidden = !show;
        input.setAttribute('aria-expanded', show ? 'true' : 'false');
    }

    function clearResults() {
        list.innerHTML = '';
        showResults(false);
        activeIndex = -1;
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function renderResults(items) {
        if (!items.length) {
            list.innerHTML = '<li class="tc-panel-search__empty">No matches found</li>';
            showResults(true);
            return;
        }

        list.innerHTML = items
            .map(function (item, idx) {
                return (
                    '<li class="tc-panel-search__item" role="option" data-index="' +
                    idx +
                    '" data-url="' +
                    escapeHtml(item.url) +
                    '">' +
                    '<span class="tc-panel-search__type">' +
                    escapeHtml(item.type) +
                    '</span>' +
                    '<span class="tc-panel-search__row">' +
                    '<i data-feather="' +
                    escapeHtml(item.icon || 'circle') +
                    '"></i>' +
                    '<span class="tc-panel-search__label">' +
                    escapeHtml(item.label) +
                    '</span>' +
                    (item.meta ? '<span class="tc-panel-search__meta">' + escapeHtml(item.meta) + '</span>' : '') +
                    '</span></li>'
                );
            })
            .join('');

        showResults(true);
        if (window.feather) {
            window.feather.replace();
        }
    }

    function fetchResults(query) {
        if (abortCtrl) {
            abortCtrl.abort();
        }
        abortCtrl = new AbortController();

        fetch(url + '?q=' + encodeURIComponent(query), {
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            signal: abortCtrl.signal,
            credentials: 'same-origin',
        })
            .then(function (res) {
                return res.json();
            })
            .then(function (data) {
                renderResults(data.results || []);
            })
            .catch(function (err) {
                if (err.name !== 'AbortError') {
                    clearResults();
                }
            });
    }

    function scheduleSearch() {
        var q = input.value.trim();
        if (timer) {
            clearTimeout(timer);
        }
        if (q.length < minChars) {
            clearResults();
            return;
        }
        timer = setTimeout(function () {
            fetchResults(q);
        }, debounceMs);
    }

    function goToIndex(idx) {
        var item = list.querySelector('[data-index="' + idx + '"]');
        if (item && item.getAttribute('data-url')) {
            window.location.href = item.getAttribute('data-url');
        }
    }

    input.addEventListener('input', scheduleSearch);
    input.addEventListener('focus', function () {
        if (input.value.trim().length >= minChars && list.children.length) {
            showResults(true);
        }
    });

    input.addEventListener('keydown', function (e) {
        var items = list.querySelectorAll('.tc-panel-search__item[data-url]');
        if (!items.length) {
            return;
        }
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIndex = Math.min(activeIndex + 1, items.length - 1);
            items.forEach(function (el, i) {
                el.classList.toggle('is-active', i === activeIndex);
            });
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIndex = Math.max(activeIndex - 1, 0);
            items.forEach(function (el, i) {
                el.classList.toggle('is-active', i === activeIndex);
            });
        } else if (e.key === 'Enter' && activeIndex >= 0) {
            e.preventDefault();
            goToIndex(activeIndex);
        } else if (e.key === 'Escape') {
            clearResults();
            input.blur();
        }
    });

    list.addEventListener('mousedown', function (e) {
        var item = e.target.closest('.tc-panel-search__item[data-url]');
        if (item) {
            e.preventDefault();
            window.location.href = item.getAttribute('data-url');
        }
    });

    document.addEventListener('click', function (e) {
        if (!root.contains(e.target)) {
            clearResults();
        }
    });

    document.addEventListener('keydown', function (e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            input.focus();
            input.select();
        }
    });

    var mobileBtn = document.getElementById('tc-panel-search-mobile-btn');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', function () {
            var q = window.prompt('Search users, products, pages');
            if (q && q.trim().length >= minChars) {
                fetch(url + '?q=' + encodeURIComponent(q.trim()), {
                    headers: { Accept: 'application/json' },
                    credentials: 'same-origin',
                })
                    .then(function (res) {
                        return res.json();
                    })
                    .then(function (data) {
                        var first = (data.results || [])[0];
                        if (first && first.url) {
                            window.location.href = first.url;
                        } else {
                            alert('No results found');
                        }
                    });
            }
        });
    }
})();
