
@include('includes.front-header')
    <!-- Navigation -->
    @include('includes.front-nav')

    <!-- Page Content -->
    <div class="container">
        <div class="page-content">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @include('includes.flash-messages')
                </div>
            </div>
            @yield('content')
        </div>
    </div>

@include('includes.front-footer')