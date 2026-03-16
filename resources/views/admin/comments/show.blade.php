
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

                        <td>{{$comment->id}}</td>
                        <td>{{$comment->author}}</td>
                        <td>{{$comment->email}}</td>
                        <td>{{$comment->body}}</td>
                        <td><a href="{{route('home.post', $comment->post->slug)}}">View Post</td>

                        <td>

                            @if ($comment->is_active == 1)

                            {!! Form::open(['method'=>'PATCH', 'action'=>['PostCommentsController@update', $comment->id]]) !!}
                                
                                <input type="hidden" name="is_active" value="0">
                                <div class='form-group'>
                                  {!! Form::submit('Disapprove', ['class'=>'btn btn-warning']) !!}
                                </div>
                            {!! Form::close() !!}
                            
                            @else 
                            
                  
                            {!! Form::open(['method'=>'PATCH', 'action'=>['PostCommentsController@update', $comment->id]]) !!}
                                
                                <input type="hidden" name="is_active" value="1">
                                <div class='form-group'>
                                  {!! Form::submit('Approve', ['class'=>'btn btn-success']) !!}
                                </div>
                            {!! Form::close() !!}

                            @endif

                        </td>

                        <td>

                            {!! Form::open(['method'=>'DELETE', 'action'=>['PostCommentsController@destroy', $comment->id]]) !!}
                                
                                <div class='form-group'>
                                  {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
                                </div>
                            {!! Form::close() !!}

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