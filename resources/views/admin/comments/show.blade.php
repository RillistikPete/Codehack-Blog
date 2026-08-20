@extends('layouts.admin')

@section('content')

    @if($comments)
        
        <h1>Comments</h1>
            
        <table class='table table-hover'>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $comment)
                        <tr>
                            <td>{{$comment->id}}</td>
                            <td>{{$comment->author}}</td>
                            <td>{{$comment->email}}</td>
                            <td>{{$comment->body}}</td>
                            <td>
                                @if ($comment->post)
                                    <a href="{{route('home.post', $comment->post->slug)}}">View Post</a>
                                @endif
                            </td>

                            <td>
                                @if ($comment->is_active == 1)
                                    <form method="POST" action="{{ route('comments.update', $comment->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="is_active" value="0">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-warning">Disapprove</button>
                                        </div>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('comments.update', $comment->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="is_active" value="1">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </div>
                                    </form>
                                @endif
                            </td>

                            <td>
                                <form method="POST" action="{{ route('comments.destroy', $comment->id) }}"
                                    onsubmit="return confirm('Delete this comment?');">
                                    @csrf
                                    @method('DELETE')
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            


            @else 
            
            
            <h1 class="text-center">No Comments</h1>

    @endif

        
     
@endsection