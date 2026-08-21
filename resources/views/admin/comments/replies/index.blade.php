@extends('layouts.admin')

@section('content')

    @if ($comment)
        <h1>Replies to {{ $comment->author }}'s comment</h1>
        <p class="text-muted">{{ Str::limit($comment->body, 120) }}</p>
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
                    <th>Reply</th>
                    <th>Post</th>
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
                        <td>
                            @if ($reply->comment?->post)
                                <a href="{{ route('home.post', $reply->comment->post->slug) }}">View Post</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
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