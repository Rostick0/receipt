@include('layout.head')

<div class="wrapper">
    @include('layout.header')
    <main class="main">
        @yield('html')
    </main>
</div>

@include('layout.footer')
