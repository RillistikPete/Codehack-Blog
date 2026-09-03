@extends('layouts.blog-home')

@section('content')
<div class="row">
    <div class="col-md-8">
        @if (request()->routeIs('home'))
            <h2>Codehack Blog</h2>
        @endif
        @if ($category)
            <h2>Posts in {{ $category->name }}</h2>
            <p><a href="{{ route('home') }}">&larr; All posts</a></p>
        @endif
        <hr>
        @forelse ($posts as $post)

            <article class="post-summary">
                <div class="post-summary-text">
                    <h3 class="post-summary-title">
                        <a href="{{ route('home.post', $post->slug) }}">{{ $post->title }}</a>
                    </h3>

                    <p class="post-summary-meta">
                        <span class="glyphicon glyphicon-time"></span>
                        {{ $post->created_at->format('j F Y') }}
                    </p>

                    @if ($post->category)
                        <p class="post-summary-cat">
                            <a href="{{ route('home.categ-posts', $post->category->id) }}">
                                {{ $post->category->name }}
                            </a>
                        </p>
                    @endif

                    <p class="post-summary-body">{{ Str::limit($post->excerpt, 200) }}</p>

                    <a href="{{ route('home.post', $post->slug) }}">Read more &rarr;</a>
                </div>

                @if ($post->obj_url)
                    <a href="{{ route('home.post', $post->slug) }}" class="post-summary-thumb">
                        <img src="{{ $post->obj_url }}" alt="{{ $post->title }}">
                    </a>
                @endif
            </article>

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