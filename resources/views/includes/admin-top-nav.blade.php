<div class="navbar-header" style="">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/">Home</a>
</div>
<!-- /.navbar-header -->


<!-- TOP NAVIGATION -->
<ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
        <i class="fa fa-user fa-fw"></i> {{Auth::user()->name}} </i>
        <li>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-link" style="padding:15px;text-decoration:none;">
                    <i class="fa fa-sign-out fa-fw"></i> Logout
                </button>
            </form>
        </li>
    </li>
</ul>

</ul>