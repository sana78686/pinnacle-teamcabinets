(function () {
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('tenant-user-form');
        if (!form || form.dataset.ajax !== '1') {
            return;
        }

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const submitBtn = form.querySelector('[data-tc-user-submit]');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            if (submitBtn) {
                submitBtn.disabled = true;
            }

            const formData = new FormData(form);
            const method = (form.querySelector('[name="_method"]')?.value || form.method || 'POST').toUpperCase();

            try {
                const res = await fetch(form.action, {
                    method: method === 'PUT' ? 'POST' : 'POST',
                    body: formData,
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                    },
                });

                const data = await res.json().catch(function () {
                    return {};
                });

                if (res.ok && data.success) {
                    if (typeof Swal !== 'undefined') {
                        await Swal.fire({
                            icon: 'success',
                            title: data.message || 'Saved',
                            timer: 1800,
                            showConfirmButton: false,
                        });
                    }
                    window.location.href = data.redirect || form.dataset.redirect || '/';
                    return;
                }

                let html = data.message || 'Please fix the errors below.';
                if (data.errors) {
                    html = '<ul class="text-start mb-0">';
                    Object.keys(data.errors).forEach(function (key) {
                        (data.errors[key] || []).forEach(function (msg) {
                            html += '<li>' + msg + '</li>';
                        });
                    });
                    html += '</ul>';
                }

                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: 'Could not save user', html: html });
                } else {
                    alert(html.replace(/<[^>]+>/g, ''));
                }
            } catch (err) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: 'Network error', text: 'Try again.' });
                }
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                }
            }
        });
    });
})();
