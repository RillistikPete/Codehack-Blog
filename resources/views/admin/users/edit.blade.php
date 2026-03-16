@extends('layouts.admin')


@section('content')

    <h1 class="text-center">Edit User Settings</h1>
    <hr>

  {{-- !!! $user->id  is required below to work for index.blade.php  {{route('users.edit', $user->id)}} --}}
  {{-- convert to model, pass in $user, this allows for access --}}

    <div class="text-center">
        <img class="img-rounded" height="200px" src="{{$user->photo ? $user->photo->file : '/images/placeholder.jpg'}}" alt="">
    </div>
    <br>
    <div class="panel-body">
            {!! Form::model($user, ['method'=>'PATCH', 'action'=>['AdminUsersController@update', $user->id], 'files'=>true]) !!}

                <div class='form-group'>
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                </div>
                
                <div class='form-group'>
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::email('email', null, ['class'=>'form-control']) !!}
                </div>

                <div class='form-group'>
                    {!! Form::label('role_id', 'Role:') !!}
                    {!! Form::select('role_id', [''=>'Choose An Option'] + $roles, null, ['class'=>'form-control']) !!}
                </div>
            
                <div class='form-group'>
                    {!! Form::label('is_active', 'Status:') !!}
                    {!! Form::select('is_active', array(1 => 'Active', 0 => 'Offline') ,null, ['class'=>'form-control']) !!}
                </div>
                
                <div class='form-group'>
                    {!! Form::label('password', 'Password:') !!}
                    {!! Form::password('password', ['class'=>'form-control']) !!}
                </div>
                
                <div class='form-group'>
                    {!! Form::label('photo_id', 'Photo:') !!}
                    {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
                </div>

                <div class='form-group'>
                    {!! Form::submit('Update User', ['class'=>'btn btn-primary col-sm-6']) !!}
                </div>

            {!! Form::close() !!}
            
            {{-- DELETE --}}
            {!! Form::open(['method'=>'DELETE', 'action'=>['AdminUsersController@destroy', $user->id], 'class'=>'']) !!}
                <div class='form-group'>
                    {!! Form::submit('Delete User', ['class'=>'btn btn-danger col-sm-6']) !!}
                </div>
            {!! Form::close() !!}
            
        </div>


    @include('includes.form_error')
       

@stop