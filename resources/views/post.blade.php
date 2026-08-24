
@extends('layouts.blog-home')


@section('content')

<div class="row">

    <div class="col-md-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1 id="postTitle">{{$post->title}}</h1>

                <!-- Author -->
                <p class="lead">
                    by {{$post->user?->name}}
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span>Post created {{$post->created_at->diffForHumans()}}</p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="{{ $post->obj_url ? $post->obj_url : $post->photoPlaceholder() }}" alt="Photo hidden">

                <hr>

                <!-- Post Content -->
                <div class="post-body">
                    {!! $post->body_html !!}
                </div>

                <hr><hr>

        <!-- Blog Comments -->
        @if(Auth::check())
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                
                <form method="POST" action="{{ route('comments.store', $post->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="body">Body:</label>
                        <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="3">{{ old('body') }}</textarea>
                        @error('body')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit Comment</button>
                    </div>
                </form>
            </div>
        @endif

        <hr>

        <!-- Posted Comments -->
        @if(count($comments) > 0)

            <!-- Comment -->
            @foreach ($comments as $comment)
                <div class="media well">
                    <img height="64" class="media-object pull-left"
                        src="{{ Auth::user() && Auth::user()->name == $comment->author
                                ? Auth::user()->gravatar
                                : '/images/icon-user-default.png' }}" alt="">
                    <div class="media-body">
                        <h4 class="media-heading">{{ $comment->author }}
                            <small>{{ $comment->created_at->diffForHumans() }}</small>
                        </h4>
                        <p>{{ $comment->body }}</p>

                        {{-- Replies --}}
                        @forelse ($comment->replies->where('is_active', 1) as $reply)
                            <div class="media nested-comment">
                                <img height="36" class="media-object pull-left"
                                    src="{{ Auth::user() && Auth::user()->name == $reply->author
                                            ? Auth::user()->gravatar
                                            : '/images/icon-user-default.png' }}" alt="">
                                <div class="media-body">
                                    <h4 class="media-heading">{{ $reply->author }}
                                        <small>{{ $reply->created_at->diffForHumans() }}</small>
                                    </h4>
                                    <p>{{ $reply->body }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted"><small>No replies yet.</small></p>
                        @endforelse

                        {{-- One reply form per comment --}}
                        @auth
                            <div class="comment-reply-container">
                                <button class="pull-right btn btn-primary toggle-reply">Reply</button>

                                <div class="comment-reply col-sm-6" style="display:none;">
                                    <form method="POST" action="{{ route('replies.store', $comment->id) }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="body-{{ $comment->id }}">Body:</label>
                                            <textarea name="body" id="body-{{ $comment->id }}" class="form-control" rows="2"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            @endforeach

        @endif

        </div>  <!-- col-md-8 -->

            @include('includes.front-sidebar')

        </div> <!-- ROW -->



        {{-- DISQUS  --}}
        
        {{--
            <hr><hr>
                
                    <div id="disqus_thread"></div>
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
                 (function() { // DON'T EDIT BELOW THIS LINE
                 var d = document, s = d.createElement('script');
                 s.src = 'https://codehacking-vqxykezwu5.disqus.com/embed.js';
                 s.setAttribute('data-timestamp', +new Date());
                 (d.head || d.body).appendChild(s);
                 })();
                 </script>
                 <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

                 <script id="dsq-count-scr" src="//codehacking-vqxykezwu5.disqus.com/count.js" async></script>

                 --}}


@stop

@section('scripts')
    
    <script>
        $(".comment-reply-container .toggle-reply").click(function() {

            console.log('clicked reply');
            $(this).next().slideToggle("slow");

        });
    </script>
    
@endsection