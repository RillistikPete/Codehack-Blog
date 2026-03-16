    @include('includes.front-header')

        <!-- Navigation -->
        @include('includes.front-nav')

        <!-- Page Content -->

        @include('includes.flash-messages')

        @yield('content')

    @include('includes.front-footer')