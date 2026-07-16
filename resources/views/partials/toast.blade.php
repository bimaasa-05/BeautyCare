@php
    $toastMessage =
        session('message') ?: session('error') ?: session('warning') ?: session('info') ?: session('status');
    $toastType = session('error') ? 'error' : (session('warning') ? 'warning' : (session('info') ? 'info' : 'success'));
@endphp
@if ($toastMessage)
    <div id="session-toast" data-message="{{ $toastMessage }}" data-type="{{ $toastType }}" style="display:none"></div>
@endif
