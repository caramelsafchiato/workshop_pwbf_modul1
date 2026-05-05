<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.header')
    @include('layouts.styleglobal')
    @include('layouts.stylepage')
</head>
<body>
    <div class="container-scroller">
        @include('layouts.navbar')

        <div class="container-fluid page-body-wrapper">
            @include('layouts.sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                
                @include('layouts.footer')
            </div>
        </div>
    </div>


    @include('layouts.javascriptglobal')
    @include('layouts.javascrippage')
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    @yield('scripts')

</body>
</html>