@extends('layouts.blog-home')

@section('content')
<div class="row">
    <div class="col-md-8">
        @forelse ($posts as $post)
            <h2 id="postTitle">
                <a href="{{ route('home.post', $post->slug) }}">{{ $post->title }}</a>
            </h2>
            <p class="lead">by {{ $post->user?->name }}</p>
            <p>
                <span class="glyphicon glyphicon-time"></span>
                Created {{ $post->created_at->diffForHumans() }}
            </p>
            <hr>
            <img class="img-responsive"
                 src="{{ $post->obj_url ?: $post->photoPlaceholder() }}"
                 alt="{{ $post->title }}">

            <hr>
            <div id="postBody">
                {{ $post->excerpt }}
            </div>
            <div class="text-center">
                <a class="btn btn-primary" href="{{ route('home.post', $post->slug) }}">
                    Go to post <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
            <hr id="bottomHr">
        @empty
            <h3 class="text-center">No posts yet.</h3>
        @endforelse
    </div>
    @include('includes.front-sidebar')
</div>

<div class="row text-center">
    {{ $posts->links() }}
</div>

@stop