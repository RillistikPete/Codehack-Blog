<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin — {{ config('app.name') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite('resources/css/admin.css')

    @yield('styles')
</head>

<body id="admin-page">
    <div id="wrapper">
        <!-- Navbar -->
        @include('includes.admin-nav')

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-dashboard fa-fw"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> Posts<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{{ route('posts.index') }}">All Posts</a></li>
                            <li><a href="{{ route('posts.create') }}">Create Post</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{{ route('users.index') }}">All Users</a></li>
                            <li><a href="{{ route('users.create') }}">Create User</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('categories.index') }}"><i class="fa fa-tags fa-fw"></i> Categories</a></li>
                    <li><a href="{{ route('comments.index') }}"><i class="fa fa-comments fa-fw"></i> Comments</a></li>
                    <li><a href="{{ route('replies.index') }}"><i class="fa fa-reply fa-fw"></i> Replies</a></li>
                    <li><a href="{{ route('media.index') }}"><i class="fa fa-picture-o fa-fw"></i> Media</a></li>
                </ul>
            </div>
        </div>

        <div id="page-wrapper">
            <div class="container-fluid">
                @include('flash::message')
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /#wrapper -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.9/metisMenu.min.js"></script>
    <script>
        $(function () { $('#side-menu').metisMenu(); });
    </script>
    @yield('scripts')

</body>
</html>