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
    <li>
        <i class="fa fa-user fa-fw"></i> {{Auth::user()->name}}
    </li>
    <li>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-link">
                <i class="fa fa-sign-out fa-fw"></i> Logout
            </button>
        </form>
    </li>
</ul>

</ul>