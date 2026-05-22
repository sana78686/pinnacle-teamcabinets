/**
 * Show Laravel session flash (success, error, info) as a centered SweetAlert dialog.
 */
(function () {
    'use strict';

    function showSessionFlash() {
        var flash = window.TC_SESSION_FLASH;
        if (!flash || !flash.message) {
            return;
        }

        if (typeof Swal === 'undefined') {
            window.alert(flash.message);
            return;
        }

        var type = flash.type || 'info';
        var title = 'Notice';
        if (type === 'success') {
            title = 'Success';
        } else if (type === 'error') {
            title = 'Error';
        } else if (type === 'info') {
            title = 'Info';
        }

        Swal.fire({
            icon: type === 'error' ? 'error' : (type === 'success' ? 'success' : 'info'),
            title: title,
            text: flash.message,
            confirmButtonText: 'OK',
            showCancelButton: false,
            showDenyButton: false,
            showCloseButton: false,
            allowOutsideClick: true,
            buttonsStyling: true,
            confirmButtonColor: '#1a4a7a',
            width: '20rem',
            padding: '1.25rem 1rem',
            customClass: {
                popup: 'tc-session-swal',
                title: 'tc-session-swal__title',
                htmlContainer: 'tc-session-swal__text',
                confirmButton: 'btn btn-primary btn-sm px-4',
            },
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', showSessionFlash);
    } else {
        showSessionFlash();
    }
})();
