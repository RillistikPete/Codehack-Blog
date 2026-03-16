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


    <!-- /.dropdown -->

    <li class="dropdown">
        
            <i class="fa fa-user fa-fw"></i> {{Auth::user()->name}} </i>

            <li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
    </li>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>

</ul>