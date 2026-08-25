@extends('layouts.blog-home')

@section('content')
<div class="row">
    <div class="col-md-8">
        @forelse ($posts as $post)
            <article class="post-summary">
                <h3 class="post-summary-title">
                    <a href="{{ route('home.post', $post->slug) }}">{{ $post->title }}</a>
                </h3>

                <p class="post-summary-meta">
                    <span class="glyphicon glyphicon-time"></span>
                    {{ $post->created_at->format('j F Y') }}
                </p>
                @if ($post->category)
                    <a href="{{ route('home.categ-posts', $post->category->id) }}">
                        {{ $post->category->name }}
                    </a>
                @endif

                <p class="post-summary-body">{{ Str::limit($post->excerpt, 200) }}</p>

                <a href="{{ route('home.post', $post->slug) }}">Read more &rarr;</a>
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