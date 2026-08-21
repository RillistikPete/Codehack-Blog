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
            <a class="navbar-brand" id="blogHome" href="/">Blog Home</a>
            {{-- <a class="navbar-brand" style="margin-left:12px;" href="/post">Create Post</a> --}}
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul id="usernameAdmin" class="nav navbar-nav navbar-right">
                @guest
                    <li>
                        <a class="loginRegLink" href="{{route('login')}}">Login</a>
                    </li>
                    <li>
                        <a class="loginRegLink" href="{{route('register')}}">Register</a>
                    </li>
                @endguest

                @auth
                    <li>
                        <h4 id="usernm" style="color:white;padding-right:20px;">{{ Auth::user()->name }}</h4>
                    </li>
                    @if (Auth::user()->isAdmin())
                        <li>
                            <!-- inline style needed bc h4 inside ul's "nav" fights bootstrap 3's navbar css -->
                            <h4 style="padding-right:20px;"> 
                                <a href="{{ route('admin.dashboard') }}">Admin</a>
                            </h4>
                        </li>
                    @endif
                    <li>
                        <h4>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" id="logoutBtn" class="btn btn-link">
                                    Logout
                                </button>
                            </form>
                        </h4>
                    </li>
                @endauth
            </ul>
        </div> <!-- /.navbar-collapse -->
    </div> <!-- /.container -->
</nav>