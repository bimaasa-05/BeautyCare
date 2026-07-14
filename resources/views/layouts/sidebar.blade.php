@php
    $role = auth()->user()->role ?? 'pelanggan';
@endphp

@if ($role === 'admin')
    @include('layouts.sidebar-admin')
@elseif ($role === 'kasir')
    @include('layouts.sidebar-kasir')
@elseif ($role === 'beautycian')
    @include('layouts.sidebar-beautycian')
@else
    @include('layouts.sidebar-pelanggan')
@endif
