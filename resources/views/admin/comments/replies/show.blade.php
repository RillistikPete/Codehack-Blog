
@extends('layouts.admin')



@section('content')
    


    @if($replies)
        
        <h1>Replies</h1>
            
        <table class='table table-hover'>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($replies as $reply)
                            <td>{{$reply->id}}</td>
                            <td>{{$reply->author}}</td>
                            <td>{{$reply->email}}</td>
                            <td>{{$reply->body}}</td>
                            <td>
                                @if ($reply->comment?->post)
                                    <a href="{{ route('home.post', $reply->comment->post->slug) }}">View Post</a>
                                @endif
                            </td>

                            <td>
                                @if ($reply->is_active == 1)
                                    <form method="POST" action="{{ route('replies.update', $reply->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="is_active" value="0">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-warning">Disapprove</button>
                                        </div>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('replies.update', $reply->id) }}">
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
                                <form method="POST" action="{{ route('replies.destroy', $reply->id) }}"
                                    onsubmit="return confirm('Delete this reply?');">
                                    @csrf
                                    @method('DELETE')
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </td>
                        @endforeach
                    </tr>
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