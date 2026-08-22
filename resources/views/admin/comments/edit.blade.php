@extends('layouts.admin')

@section('content')

    <h1>Edit Comment</h1>

    <p>
        @if ($comment->post)
            On <a href="{{ route('home.post', $comment->post->slug) }}">{{ $comment->post->title }}</a>
        @else
            <span class="text-muted">Post no longer exists</span>
        @endif
        &middot; {{ $comment->created_at->diffForHumans() }}
    </p>

    <hr>

    <div class="row">
        <div class="col-sm-8">

            <form method="POST" action="{{ route('comments.update', $comment->id) }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="author">Author:</label><p>{{$comment->author}}</p>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label><p>{{$comment->email}}</p>
                </div>

                <div class="form-group">
                    <label for="body">Comment:</label>
                    <textarea name="body" id="body" class="form-control" rows="5">{{ old('body', $comment->body) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="is_active">Status:</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="1" @selected(old('is_active', $comment->is_active) == 1)>Approved</option>
                        <option value="0" @selected(old('is_active', $comment->is_active) == 0)>Pending</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Comment</button>
                <a href="{{ route('comments.index') }}" class="btn btn-default">Cancel</a>
            </form>

            <hr>

            <form method="POST" action="{{ route('comments.destroy', $comment->id) }}"
                  onsubmit="return confirm('Deleting this comment will delete all its replies. Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Comment</button>
            </form>

        </div>

        <div class="col-sm-4">
            <h4>Replies ({{ $comment->replies->count() }})</h4>

            @forelse ($comment->replies as $reply)
                <div class="well well-sm">
                    <strong>{{ $reply->author }}</strong>
                    <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                    <p>{{ Str::limit($reply->body, 100) }}</p>
                    <span class="label label-{{ $reply->is_active ? 'success' : 'warning' }}">
                        {{ $reply->is_active ? 'Approved' : 'Pending' }}
                    </span>
                </div>
            @empty
                <p class="text-muted">No replies.</p>
            @endforelse

            @if ($comment->replies->count())
                <a href="{{ route('replies.index', ['comment' => $comment->id]) }}">Manage replies &rarr;</a>
            @endif
        </div>
    </div>

    @include('includes.form_error')

@endsection