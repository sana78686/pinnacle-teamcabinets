(function () {
    if (!window.TENANT_NOTIFICATIONS_POLL_URL) {
        return;
    }

    var pollUrl = window.TENANT_NOTIFICATIONS_POLL_URL;
    var readUrlTemplate = window.TENANT_NOTIFICATIONS_READ_URL || '';
    var readAllUrl = window.TENANT_NOTIFICATIONS_READ_ALL_URL || '';
    var pollIntervalMs = window.TENANT_NOTIFICATIONS_POLL_MS || 45000;
    var lastSince = localStorage.getItem('tc_notifications_since') || null;
    var knownIds = new Set();

    function csrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function el(id) {
        return document.getElementById(id);
    }

    function updateBadge(count) {
        var badge = el('tc-notification-badge');
        if (!badge) return;
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : String(count);
            badge.style.display = 'inline-flex';
        } else {
            badge.style.display = 'none';
        }
    }

    function updateSummary(count) {
        var summary = el('tc-notification-summary');
        if (summary) {
            summary.textContent = count === 1
                ? 'You have 1 unread notification'
                : 'You have ' + count + ' unread notifications';
        }
    }

    function iconClass(type) {
        if (type === 'success') return 'bg-success';
        if (type === 'warning') return 'bg-warning';
        if (type === 'danger' || type === 'error') return 'bg-danger';
        return 'bg-info';
    }

    function renderList(items) {
        var list = el('tc-notification-list');
        if (!list) return;

        if (!items.length) {
            list.innerHTML = '<li class="p-3 text-muted text-center">No notifications yet</li>';
            return;
        }

        list.innerHTML = items.map(function (n) {
            var unread = !n.read_at;
            var link = n.url ? ' href="' + n.url + '" data-notification-id="' + n.id + '"' : '';
            var tag = n.url ? 'a' : 'div';
            return (
                '<li class="tc-notification-item' + (unread ? ' tc-notification-item--unread' : '') + '">' +
                '<' + tag + link + ' class="media tc-notification-link">' +
                '<div class="mr-3 notification-icons ' + iconClass(n.type) + '"><i class="mt-0" data-feather="bell"></i></div>' +
                '<div class="media-body">' +
                '<h6 class="mb-0">' + escapeHtml(n.title) + '</h6>' +
                '<p class="mb-0">' + escapeHtml(n.message) + '</p>' +
                '<small class="text-muted">' + escapeHtml(n.created_at) + '</small>' +
                '</div>' +
                '</' + tag + '>' +
                '</li>'
            );
        }).join('');

        if (window.feather) {
            window.feather.replace();
        }

        list.querySelectorAll('.tc-notification-link').forEach(function (anchor) {
            anchor.addEventListener('click', function () {
                var id = anchor.getAttribute('data-notification-id');
                if (id) markRead(id);
            });
        });
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function markRead(id) {
        if (!readUrlTemplate) return;
        var url = readUrlTemplate.replace('__ID__', encodeURIComponent(id));
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            credentials: 'same-origin',
        }).then(function () {
            poll(false);
        });
    }

    function markAllRead() {
        if (!readAllUrl) return;
        fetch(readAllUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
        }).then(function () {
            poll(false);
        });
    }

    function showBrowserAlert(item) {
        if (!('Notification' in window)) return;
        if (Notification.permission === 'granted') {
            new Notification(item.title, { body: item.message });
        }
    }

    function showToast(item) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: item.type === 'success' ? 'success' : 'info',
                title: item.title,
                text: item.message,
                showConfirmButton: !!item.url,
                confirmButtonText: item.url ? 'View' : undefined,
                timer: item.url ? undefined : 6000,
                timerProgressBar: !item.url,
            }).then(function (result) {
                if (result.isConfirmed && item.url) {
                    window.location.href = item.url;
                }
            });
        }
    }

    function handleNewItems(items) {
        items.forEach(function (item) {
            if (knownIds.has(item.id)) return;
            knownIds.add(item.id);
            showToast(item);
            showBrowserAlert(item);
        });
    }

    function poll(isInitial) {
        var url = pollUrl;
        if (lastSince) {
            url += (url.indexOf('?') >= 0 ? '&' : '?') + 'since=' + encodeURIComponent(lastSince);
        }

        fetch(url, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin',
        })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                updateBadge(data.unread_count || 0);
                updateSummary(data.unread_count || 0);
                renderList(data.notifications || []);

                if (!isInitial && data.new && data.new.length) {
                    handleNewItems(data.new);
                }

                (data.notifications || []).forEach(function (n) {
                    knownIds.add(n.id);
                });

                lastSince = new Date().toISOString();
                localStorage.setItem('tc_notifications_since', lastSince);
            })
            .catch(function () {});
    }

    document.addEventListener('DOMContentLoaded', function () {
        var markAllBtn = el('tc-notification-mark-all');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', function (e) {
                e.preventDefault();
                markAllRead();
            });
        }

        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        poll(true);
        setInterval(function () { poll(false); }, pollIntervalMs);
    });
})();
