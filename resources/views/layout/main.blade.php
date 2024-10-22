@include('layout.header')
<h1>Welcome to Home care nepal</h1>

    {{-- navbar  --}}
    <div class="container">
        @include('navbar')
    </div>
@yield('content')

@include('layout.footer')
