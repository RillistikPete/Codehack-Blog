<!-- Blog Posts col-md-8 -->   
<div class="col-md-8">
    
        @if ($posts)
                    
            @foreach ($posts as $post)
    
            <h2>
                <a href="#">{{$post->title}}</a>
            </h2>
                <p class="lead">
                    by {{$post->user->name}}
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Created {{$post->created_at->diffForHumans()}}</p>
                <hr>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
    
                        <p>
                            {!!str_limit($post->body , 200)!!}
                        </p>
    
                <a class="btn btn-primary" href="/post/{{$post->slug}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
    
                <hr>
    
            @endforeach
        @endif
</div>