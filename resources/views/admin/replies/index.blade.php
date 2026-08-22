@extends('layouts.admin')

@section('content')

    @if ($filterComment)
        <h2>Replies to {{ $filterComment->author }}'s comment</h2>

        @if ($filterComment->post)
            <p class="text-muted">
                on <a href="{{ route('home.post', $filterComment->post->slug) }}">{{ $filterComment->post->title }}</a>
            </p>
        @endif

        <blockquote>
            <p>{{ Str::limit($filterComment->body, 300) }}</p>
        </blockquote>

        <p><a href="{{ route('replies.index') }}">&larr; All replies</a></p>
    @else
        <h1>All Replies</h1>
    @endif

    @if ($replies->count() > 0)

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Email</th>
                    <th>Comment</th>
                    <th>Edit</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($replies as $reply)
                    <tr>
                        <td>{{ $reply->id }}</td>
                        <td>{{ $reply->author }}</td>
                        <td>{{ $reply->email }}</td>
                        <td>{{ Str::limit($reply->body, 60) }}</td>
                        <td><a href="{{ route('replies.edit', $reply->id) }}">Edit Reply</a></td>
                        <td>
                            @if ($reply->is_active == 1)
                                <form method="POST" action="{{ route('replies.update', $reply->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_active" value="0">
                                    <button type="submit" class="btn btn-warning btn-sm">Disapprove</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('replies.update', $reply->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_active" value="1">
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('replies.destroy', $reply->id) }}"
                                  onsubmit="return confirm('Delete this reply?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center">
            {{ $replies->appends(request()->query())->links() }}
        </div>

    @else
        <h3 class="text-center">No replies{{ $comment ? ' to this comment' : '' }} yet.</h3>
    @endif

@endsection