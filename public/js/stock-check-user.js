(function () {
    var form = document.getElementById('sc-item-notes-form');
    var btn = document.getElementById('sc-btn-update-notes');
    var msg = document.getElementById('sc-user-status-msg');

    if (!form || !btn) {
        return;
    }

    function showMsg(text, ok) {
        if (!msg) {
            return;
        }
        msg.textContent = text;
        msg.className = 'alert py-2 mb-3 alert-' + (ok ? 'success' : 'danger');
        msg.style.display = 'block';
    }

    btn.addEventListener('click', function () {
        var action = form.getAttribute('action');
        if (!action || action === '#') {
            return;
        }

        btn.disabled = true;
        var body = new FormData(form);

        fetch(action, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: body,
            credentials: 'same-origin',
        })
            .then(function (res) {
                return res.json().then(function (data) {
                    if (!res.ok) {
                        throw new Error((data && data.message) || 'Could not save item notes.');
                    }
                    return data;
                });
            })
            .then(function (data) {
                showMsg(data.message || 'Item notes updated successfully.', true);
            })
            .catch(function (err) {
                showMsg(err.message || 'Could not save item notes.', false);
            })
            .finally(function () {
                btn.disabled = false;
            });
    });
})();
