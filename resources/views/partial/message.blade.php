@php
    $tcFlashType = null;
    $tcFlashMessage = null;
    if (session('success')) {
        $tcFlashType = 'success';
        $tcFlashMessage = session('success');
    } elseif (session('error')) {
        $tcFlashType = 'error';
        $tcFlashMessage = session('error');
    } elseif (session('info')) {
        $tcFlashType = 'info';
        $tcFlashMessage = session('info');
    }
@endphp
@if ($tcFlashType && $tcFlashMessage)
    <script>
        window.TC_SESSION_FLASH = { type: @json($tcFlashType), message: @json($tcFlashMessage) };
    </script>
@endif
