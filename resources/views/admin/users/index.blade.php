
@extends('layouts.admin')

@section('content')

@if(Session::has('deleted_user'))
<p class="bg-danger">{{session('deleted_user')}}</p>
@endif

<h1>Users</h1>
<hr>
    <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created</th>
                <th>Updated</th>

            </tr>
            </thead>
        <tbody>
            @if($users)

            @foreach ($users as $user) 
                <tr>
                    <td>{{$user->id}}</td>
                    <td><x-photo :photo="$user->photo" height="50" width="50" /></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td><a href="{{route('users.edit', $user->id)}}">Edit User</td>
                    <td>{{$user->role->name}}</td>

                    <td>{{$user->is_active == 1 ? 'Active' : 'Offline' }}</td>

                    <td>{{$user->created_at->diffForHumans()}}</td>
                    <td>{{$user->updated_at->diffForHumans()}}</td>
                </tr>
            @endforeach

        @endif

        </tbody>
    </table>

@endsection