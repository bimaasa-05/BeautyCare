@include('layouts.header')

@yield('content')

{{ $slot ?? '' }}

@hasSection('hide_footer')
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/animation.js') }}"></script>
    @stack('scripts')
    </body>
    </html>
@else
    @include('layouts.footer')
@endif
