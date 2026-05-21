/**
 * Adds show/hide toggle to all password inputs.
 */
(function () {
    function enhance(input) {
        if (!input || input.type !== 'password' || input.dataset.tcPasswordToggle === '1') {
            return;
        }

        var container = input.closest('.tc-input-wrap') || input.parentElement;
        if (!container || container.querySelector('.tc-password-toggle')) {
            return;
        }

        if (!input.closest('.tc-input-wrap')) {
            var wrap = document.createElement('div');
            wrap.className = 'tc-password-wrap';
            container.insertBefore(wrap, input);
            wrap.appendChild(input);
            container = wrap;
        }

        container.classList.add('tc-input-wrap--password');
        if (getComputedStyle(container).position === 'static') {
            container.style.position = 'relative';
        }

        if (container.querySelector('.tc-icon')) {
            input.style.paddingRight = '2.75rem';
        } else if (input.classList.contains('tc-input')) {
            input.style.paddingRight = '2.75rem';
        } else if (input.classList.contains('form-control') || input.classList.contains('pn-input')) {
            input.style.paddingRight = '2.75rem';
        }

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'tc-password-toggle';
        btn.setAttribute('aria-label', 'Show password');
        btn.innerHTML = '<i class="fa-regular fa-eye" aria-hidden="true"></i>';

        btn.addEventListener('click', function () {
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            btn.innerHTML = show
                ? '<i class="fa-regular fa-eye-slash" aria-hidden="true"></i>'
                : '<i class="fa-regular fa-eye" aria-hidden="true"></i>';
        });

        container.appendChild(btn);
        input.dataset.tcPasswordToggle = '1';
    }

    function init(root) {
        (root || document).querySelectorAll('input[type="password"]').forEach(enhance);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            init(document);
        });
    } else {
        init(document);
    }

    window.TcPasswordToggle = { refresh: init };
})();
