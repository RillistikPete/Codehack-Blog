<nav class="navbar navbar-inverse navbar-sticky-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Blog Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @guest
                    <li>
                        <a class="loginRegLink" href="{{route('login')}}">Login</a>
                    </li>
                    <li>
                        <a class="loginRegLink" href="{{route('register')}}">Register</a>
                    </li>
                @endguest

                @auth
                    <li><a class="frontnav-username"><i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }}</a></li>

                    @if (Auth::user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Admin</a></li>
                    @endif

                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-link"><i class="fa fa-sign-out fa-fw"></i> Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div> <!-- /.navbar-collapse -->
    </div> <!-- /.container -->
</nav>