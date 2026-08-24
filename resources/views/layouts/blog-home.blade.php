
@include('includes.front-header')
    <!-- Navigation -->
    @include('includes.front-nav')

    <!-- Page Content -->
    <div class="container">
        <div class="page-content">
            @include('includes.flash-messages')
            @yield('content')
        </div>
    </div>

@include('includes.front-footer')