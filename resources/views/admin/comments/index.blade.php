@extends('layouts.admin')

@section('content')

    @if ($post)
        <h2>Comments on {{ $post->user?->name }}'s post</h2>

        <blockquote>
            <a href="{{ route('home.post', $post->slug) }}">{{ $post->title }}</a>
        </blockquote>

        <p><a href="{{ route('comments.index') }}">&larr; All Comments</a></p>
    @else
        <h1>All Comments</h1>
    @endif

    @if ($comments->count() > 0)

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Email</th>
                    <th>Comment</th>
                    <th>Edit</th>
                    <th>Post</th>
                    <th>Replies</th>
                    <th>Status</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->author }}</td>
                        <td>{{ $comment->email }}</td>
                        <td>{{ Str::limit($comment->body, 60) }}</td>
                        <td><a href="{{ route('comments.edit', $comment->id) }}">Edit</a></td>
                        <td>
                            @if ($comment->post)
                                <a href="{{ route('home.post', $comment->post->slug) }}">View Post</a>
                            @else
                                <span class="text-muted">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('replies.index', ['comment' => $comment->id]) }}">
                                View Replies
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('comments.update', $comment->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_active"
                                       value="{{ $comment->is_active == 1 ? 0 : 1 }}">
                                <button type="submit"
                                        class="btn btn-sm {{ $comment->is_active == 1 ? 'btn-warning' : 'btn-success' }}">
                                    {{ $comment->is_active == 1 ? 'Disapprove' : 'Approve' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('comments.destroy', $comment->id) }}"
                                  onsubmit="return confirm('Delete this comment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center">{{ $comments->appends(request()->query())->links() }}</div>

    @else
        <h3 class="text-center">No comments{{ $post ? ' on this post' : '' }} yet.</h3>
    @endif

@endsection