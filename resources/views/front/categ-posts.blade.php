
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
                    by {{$post->user->name}}
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Created {{$post->created_at->diffForHumans()}}</p>
                <hr>

                <img class="img-responsive" src="{{ $post->obj_url ? $post->obj_url : $post->photoPlaceholder() }}" alt="{{ $post->photo->file }}">

                <hr>
                <p>
                    {!! $post->body !!}
                    {{-- {!!str_limit($post->body , 200)!!} --}}
                </p>
    
                <div class="text-center">
                    <a class="btn btn-primary" href="/post/{{$post->slug}}">Go to post <span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
        
                <hr id="bottomHr">
								
            @endforeach

        @endif



{{-- COMMENTS SECTION DONE MANUALLY, NO DISQUS --}}


        <!-- Blog Comments -->

        @if(Auth::check())

            <!-- Comments Form -->
            <div class="well">

                <h4>Leave a Comment:</h4>
                
                {!! Form::open(['method'=>'POST', 'action'=>'PostCommentsController@store']) !!}

                <input type="hidden" name="post_id" value="{{$post->id}}">


                    <div class='form-group'>
                    {!! Form::label('body', 'Body:') !!}
                    {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>3]) !!}
                    </div>
                    <div class='form-group'>
                    {!! Form::submit('Submit Comment', ['class'=>'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}

            </div>
        @endif

            <hr>


            <!-- Posted Comments -->

        {{-- @if(count($postComments) > 0)
        

            <!-- Comment -->
            @foreach ($post->comments as $comment)
            @if ($comment->is_active == 1)
                
            <div class="media">
                <a class="pull-left" href="#">
                <img height="60" width="60" class="media-object" src="{{Auth::user() && Auth::user()->name == $comment->author ? Auth::user()->gravatar : "/images/icon-user-default.png"}}" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{$comment->author}}
                        <small>{{$comment->created_at->diffForHumans()}}</small>
                    </h4>
                   <p>{{$comment->body}}</p>
                

                @if(count($comment->replies) > 0)

                    @foreach ($comment->replies as $reply)
                        
                        @if ($reply->is_active == 1 && Auth::user())

                            <!-- Nested Comment -->
                            <div id="nested-comment" class="media">
                                <a class="pull-left" href="#">
                                <img class="media-object" height="64" src="{{$reply->photo}}" alt="">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">{{$reply->author}}
                                        <small>{{$reply->created_at->diffForHumans()}}</small>
                                    </h4>
                                    <p>{{$reply->body}}</p>
                                </div>

                                    <div class="comment-reply-container">
                        
                                            <button class="pull-right btn btn-primary toggle-reply">Reply</button>

                                            <div class="comment-reply col-sm-6" style="display:none;">
                                                
                                                {!! Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply']) !!}

                                                <input type="hidden" name="comment_id" value="{{$comment->id}}">
            
                                                    <div class='form-group'>
                                                    {!! Form::label('body', 'Body:') !!}
                                                    {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>1]) !!}
                                                    </div>
                                                    <div class='form-group'>
                                                    {!! Form::submit('Submit', null, ['class'=>'btn btn-primary']) !!}
                                                    </div>
                                                {!! Form::close() !!}

                                            </div>
                                    </div>
                            </div>
                            <!-- End Nested Comment -->

                        {{-- @else 
                            <h3>No Replies</h3>    --}}
{{--
                        @endif

                    @endforeach

                @endif


                </div>
            </div>
            @endif  {{-- if comment is_active   --}}
{{--
            @endforeach

        @endif  --}}

        </div>  <!-- col-md-8 -->

            @include('includes.front-sidebar')

        </div> <!-- ROW -->

                 <!-- Pagination -->
                 <div class="row text-center">
                     {{$posts->render()}}
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