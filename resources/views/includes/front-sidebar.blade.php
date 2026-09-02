<div class="col-md-4">

    <!-- Blog Search Well -->
    <!-- <div class="well">
        <h4>Blog Search</h4>
        <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div> -->

    <div class="well">
        <h4>About</h4>
        <hr class="well-divider">
        <p>
            Gavin Forrest is a full-stack developer working mainly in
            <strong>C# / ASP.NET Core / Azure</strong> and <strong>PHP/Laravel</strong>,
            with SQL, Postgres, Docker and AWS underneath.
        </p>
        <p>
            I write about the problems that don't have a clean answer online - things I've run into and my debugging
            paths that actually worked. I hope you find them useful. Thanks for visiting.
        </p>
        <p>
            <a href="{{ route('contact') }}">Get in touch</a>.
        </p>
    </div>

    <div class="well">
        <h4>Contact</h4>
        <hr class="well-divider">
        <ul class="list-inline social-links">
            <li>
                <a href="https://stackoverflow.com/users/9916030/pkucas?tab=profile" title="Stack Overflow" target="_blank" rel="noopener">
                    <i class="fa fa-stack-overflow fa-2x"></i>
                </a>
            </li>
            <li>
                <a href="https://github.com/RillistikPete" title="GitHub" target="_blank" rel="noopener">
                    <i class="fa fa-github fa-2x"></i>
                </a>
            </li>
            <li>
                <a href="https://www.linkedin.com/in/gavin-forrest-345b05143/" title="LinkedIn" target="_blank" rel="noopener">
                    <i class="fa fa-linkedin fa-2x"></i>
                </a>
            </li>
        </ul>
        <a class="btn btn-primary" style="margin-top:15px;" href="{{ route('contact') }}">Send An Email</a>
    </div>

    <div class="well">
        <h4>Blog Categories</h4>
        <hr class="well-divider">
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    @if ($categories)
                        @foreach ($categories as $category)  
                            <li><a href="{{route('home.categ-posts', $category->id)}}">{{$category->name}}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>