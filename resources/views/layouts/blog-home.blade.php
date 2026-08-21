
@include('includes.front-header')
    <!-- Navigation -->
    @include('includes.front-nav')

    <!-- Page Content -->
    <div class="container">
        @include('includes.flash-messages')
        @yield('content')
    </div>

@include('includes.front-footer')