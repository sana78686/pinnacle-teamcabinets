(function () {
    var form = document.getElementById('sc-item-notes-form');
    var btn = document.getElementById('sc-btn-update-notes');
    var msg = document.getElementById('sc-user-status-msg');
    var proceedBtn = document.getElementById('sc-btn-proceed-checkout');
    var proceedForm = document.getElementById('sc-proceed-checkout-form');
    var proceedConfirm = document.getElementById('sc-proceed-checkout-confirm');
    var approveModal = document.getElementById('userStockCheckApproveModal');

    if (proceedBtn && proceedForm && approveModal) {
        proceedBtn.addEventListener('click', function () {
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                bootstrap.Modal.getOrCreateInstance(approveModal).show();
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
                $(approveModal).modal('show');
            } else if (window.confirm('Proceed to checkout with this stock check?')) {
                proceedForm.submit();
            }
        });

        if (proceedConfirm) {
            proceedConfirm.addEventListener('click', function () {
                proceedForm.submit();
            });
        }
    }

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
