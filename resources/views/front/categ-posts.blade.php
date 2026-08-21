
@extends('layouts.blog-home')


@section('content')

{{-- <div class="row">
    <div class="text-center" style="font-size:1.5em;height:100;margin-bottom:40px;">Welcome to my blog! Feel free to post anything you would like to share!</div>
</div> --}}

<div class="row">

    <div class="col-md-8">

        @if ($posts)
            @foreach ($posts as $post)
                <h2 id="postTitle">
                    <a href="/post/{{$post->slug}}">{{$post->title}}</a>
                </h2>
                <p class="lead">
                    by {{$post->user?->name}}
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Created {{$post->created_at->diffForHumans()}}</p>
                <hr>

                <img class="img-responsive" src="{{ $post->obj_url ? $post->obj_url : $post->photoPlaceholder() }}" alt="{{ $post->photo?->file }}">

                <hr>
                <p>
                    <div id="postBody">
                        {{ $post->excerpt }}
                    </div>
                </p>
    
                <div class="text-center">
                    <a class="btn btn-primary" href="/post/{{$post->slug}}">Go to post <span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
        
                <hr id="bottomHr">			
            @endforeach
        @endif

    </div>  <!-- col-md-8 -->

@include('includes.front-sidebar')

</div> <!-- ROW -->

<!-- Pagination -->
<div class="row text-center">
    <!-- {{$posts->render()}} -->
     {{ $posts->links() }} 
</div>

@stop

@section('scripts')
    
    <script>
        $(".comment-reply-container .toggle-reply").click(function() {

            console.log('clicked reply');
            $(this).next().slideToggle("slow");

        });
    </script>

    <script>

    /**
    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
    /*
    var disqus_config = function () {
    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
    };
    */
    // (function() { // DON'T EDIT BELOW THIS LINE
    // var d = document, s = d.createElement('script');
    // s.src = 'https://codehacking-vqxykezwu5.disqus.com/embed.js';
    // s.setAttribute('data-timestamp', +new Date());
    // (d.head || d.body).appendChild(s);
    // })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
            
    
@endsection