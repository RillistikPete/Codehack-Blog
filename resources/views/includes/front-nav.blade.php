<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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

                @if(Auth::guest())

                    <li>
                        <a id="loginRegLink" href="{{url('/login')}}">Login</a>
                    </li>
                    <li>
                        <a id="loginRegLink" href="{{url('/register')}}">Register</a>
                    </li>

                @elseif($user->isAdmin())

                    <li>
                        <h4 id="usernm"> {{Auth::user()->name}} </h4>
                    </li>
                    <li>
                        <h4 style="padding-right:20px;"><a href="{{url('/admin')}}">Admin</a></h4>
                    </li>

                    <li>
                        <h4><a href="{{url('/logout')}}">Logout</a></h4>
                    </li>

                @else

                    <li>
                        <h4 style="color:white;padding-right:20px;"> {{Auth::user()->name}} </h4>
                    </li>

                    <li>
                        <h4><a href="{{url('/logout')}}">Logout</a></h4>
                    </li>

                @endif

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->

</nav>

<div class="container">