<div class="col-md-4">

    <!-- Blog Search Well -->
    {{-- <div class="well">
        <h4>Blog Search</h4>
        <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div> --}}


    <!-- Side Widget Well -->
    <div class="well">
            <h4>Laravel Blog</h4>
            <p>This blog was built with Laravel 5.7. To comment on existing posts, login or register a new account. 
                You will be assigned as a subscriber. If you have an idea for a post, contact me and I'll grant you the role "author",
                allowing you to leave posts. Reach me at my <a href="/contact">email.</a></p>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">

                    @if ($categories)

                        @foreach ($categories as $category)
                            
                            <li><a href="{{route('home.categ-posts', $category->id)}}">{{$category->name}}</a>
                            </li>

                        @endforeach

                    @endif
                </ul>
            </div>  <!-- /.col-lg-6 -->

        </div> <!-- /.row -->
    </div>

    <div class="well text-center">
        <h3 style="margin-top:-10px;">Contact Me</h3>
        <a class="btn btn-primary" href="/contact">Send An Email</a>
    </div>
</div>

<style type="text/css">
    .well {
        box-shadow:1px;
        border-radius:10px;
    }
</style>