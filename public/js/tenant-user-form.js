(function () {
    function appendDoorFactorPayload(formData) {
        const seenCatalogs = new Set();

        document.querySelectorAll('.product-catalog-checkbox:checked').forEach(function (checkbox) {
            const catalogId = checkbox.dataset.catalogId || checkbox.value;
            if (! catalogId || seenCatalogs.has(catalogId)) {
                return;
            }
            seenCatalogs.add(catalogId);
            formData.append('catalog_visibility[' + catalogId + ']', catalogId);

            const container = document.querySelector(
                '.door-colors-container[data-catalog-id="' + catalogId + '"]'
            );
            if (! container) {
                return;
            }

            container.querySelectorAll('.door-factor-input').forEach(function (input) {
                if (! input.name) {
                    return;
                }
                formData.delete(input.name);
                const value = String(input.value || '').trim();
                if (value !== '') {
                    formData.append(input.name, value);
                }
            });
        });
    }

    function setSubmitLoading(submitBtn, loading) {
        if (! submitBtn) {
            return;
        }
        if (loading) {
            if (! submitBtn.dataset.tcOriginalHtml) {
                submitBtn.dataset.tcOriginalHtml = submitBtn.innerHTML;
            }
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving…';
            submitBtn.setAttribute('aria-busy', 'true');
            return;
        }
        submitBtn.disabled = false;
        submitBtn.innerHTML = submitBtn.dataset.tcOriginalHtml || submitBtn.innerHTML;
        submitBtn.removeAttribute('aria-busy');
    }

    function showSwalError(html) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'error', title: 'Could not save user', html: html });
            return;
        }
        const text = String(html).replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();
        window.alert(text || 'Could not save user.');
    }

    function initTenantUserForm() {
        const form = document.getElementById('tenant-user-form');
        if (! form || form.dataset.ajax !== '1') {
            return;
        }

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const submitBtn = form.querySelector('[data-tc-user-submit]');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            setSubmitLoading(submitBtn, true);

            const formData = new FormData(form);
            appendDoorFactorPayload(formData);

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

                let data = {};
                const contentType = res.headers.get('content-type') || '';
                if (contentType.includes('application/json')) {
                    data = await res.json();
                } else {
                    const text = await res.text();
                    data = {
                        success: false,
                        message: res.ok
                            ? 'Unexpected server response.'
                            : (text && text.length < 200 ? text : 'Server error (' + res.status + ').'),
                    };
                }

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

                showSwalError(html);
            } catch (err) {
                showSwalError('Network error. Please try again.');
            } finally {
                setSubmitLoading(submitBtn, false);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTenantUserForm);
    } else {
        initTenantUserForm();
    }
})();
