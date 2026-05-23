/**
 * Centered SweetAlert for session flash and panel toasts (login welcome, saves, etc.).
 */
(function () {
    'use strict';

    function normalizeIcon(type) {
        if (type === 'success') return 'success';
        if (type === 'error' || type === 'danger') return 'error';
        if (type === 'warning') return 'warning';
        return 'info';
    }

    function defaultTitle(type, title) {
        if (title) return title;
        if (type === 'success') return 'Success';
        if (type === 'error' || type === 'danger') return 'Error';
        if (type === 'warning') return 'Notice';
        return 'Info';
    }

    /**
     * @param {{ type?: string, title?: string, message?: string, text?: string }} item
     */
    window.TcPanelCenterAlert = function (item) {
        item = item || {};
        var message = item.message || item.text || '';
        if (!message) return Promise.resolve();

        if (typeof Swal === 'undefined') {
            window.alert(message);
            return Promise.resolve();
        }

        var type = item.type || 'info';

        return Swal.fire({
            icon: normalizeIcon(type),
            title: defaultTitle(type, item.title),
            text: message,
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
    };

    function showSessionFlash() {
        var flash = window.TC_SESSION_FLASH;
        if (!flash || !flash.message) return;
        window.TcPanelCenterAlert({
            type: flash.type,
            title: null,
            message: flash.message,
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', showSessionFlash);
    } else {
        showSessionFlash();
    }
})();
