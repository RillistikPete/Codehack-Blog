<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard fa-fw"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="#"><i class="fa fa-file-text-o fa-fw"></i> Posts<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('posts.index') }}">All Posts</a></li>
                    <li><a href="{{ route('posts.create') }}">Create Post</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-comments fa-fw"></i> Discussion<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('comments.index') }}">Comments</a></li>
                    <li><a href="{{ route('replies.index') }}">Replies</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('users.index') }}">All Users</a></li>
                    <li><a href="{{ route('users.create') }}">Create User</a></li>
                </ul>
            </li>
            
            <li>
                <a href="#"><i class="fa fa-picture-o fa-fw"></i> Media<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('media.index') }}">All Media</a></li>
                    <li><a href="{{ route('media.create') }}">Upload Media</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('categories.index') }}">
                    <i class="fa fa-tags fa-fw"></i> Categories
                </a>
            </li>

        </ul>
    </div>
</div>