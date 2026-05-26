(function () {
    function submitForm(form) {
        var pageInput = form.querySelector('input[name="page"]');
        if (pageInput) {
            pageInput.remove();
        }
        form.submit();
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-tc-list-filter]').forEach(function (form) {
            var search = form.querySelector('[name="search"]');
            var perPage = form.querySelector('[data-tc-list-per-page]');
            var clearBtn = form.querySelector('[data-tc-list-clear]');
            var debounceTimer;

            if (perPage) {
                perPage.addEventListener('change', function () {
                    submitForm(form);
                });
            }

            var userType = form.querySelector('[data-tc-list-user-type]');
            if (userType) {
                userType.addEventListener('change', function () {
                    submitForm(form);
                });
            }

            if (search) {
                search.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        submitForm(form);
                    }
                });
                search.addEventListener('input', function () {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function () {
                        submitForm(form);
                    }, 500);
                });
            }

            if (clearBtn) {
                clearBtn.addEventListener('click', function () {
                    if (search) {
                        search.value = '';
                    }
                    submitForm(form);
                });
            }
        });
    });
})();
