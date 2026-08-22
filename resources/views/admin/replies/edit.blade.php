@extends('layouts.admin')

@section('content')

    <h1>Edit Reply</h1>

    <p>
        @if ($reply->comment)
            Reply to comment #{{ $reply->comment->id }} by {{ $reply->comment->author }}
            @if ($reply->comment->post)
                on <a href="{{ route('home.post', $reply->comment->post->slug) }}">{{ $reply->comment->post->title }}</a>
            @endif
        @else
            <span class="text-muted">Parent comment no longer exists</span>
        @endif
        &middot; {{ $reply->created_at->diffForHumans() }}
    </p>

    <hr>

    <div class="row">
        <div class="col-sm-8">

            <form method="POST" action="{{ route('replies.update', $reply->id) }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label>Author:</label>
                    <p class="form-control-static">{{ $reply->author }}</p>
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <p class="form-control-static">{{ $reply->email }}</p>
                </div>

                <div class="form-group">
                    <label for="body">Reply:</label>
                    <textarea name="body" id="body" class="form-control" rows="5">{{ old('body', $reply->body) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="is_active">Status:</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="1" @selected(old('is_active', $reply->is_active) == 1)>Approved</option>
                        <option value="0" @selected(old('is_active', $reply->is_active) == 0)>Pending</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Reply</button>
                <a href="{{ route('replies.index') }}" class="btn btn-default">Cancel</a>
            </form>

            <hr>

            <form method="POST" action="{{ route('replies.destroy', $reply->id) }}"
                  onsubmit="return confirm('Delete this reply?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Reply</button>
            </form>

        </div>

        <div class="col-sm-4">
            @if ($reply->comment)
                <h4>Parent comment</h4>
                <div class="well well-sm">
                    <strong>{{ $reply->comment->author }}</strong>
                    <small class="text-muted">{{ $reply->comment->created_at->diffForHumans() }}</small>
                    <p>{{ Str::limit($reply->comment->body, 200) }}</p>
                </div>
                <a href="{{ route('comments.edit', $reply->comment->id) }}">Edit parent comment &rarr;</a><br>
                <a href="{{ route('replies.index', ['comment' => $reply->comment->id]) }}">All replies to it &rarr;</a>
            @endif
        </div>
    </div>

    @include('includes.form_error')

@endsection