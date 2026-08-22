@extends('layouts.admin')


@section('content')

    <h1 class="text-center">Edit User Settings</h1>
    <hr>

  {{-- !!! $user->id  is required below to work for index.blade.php  {{route('users.edit', $user->id)}} --}}
  {{-- convert to model, pass in $user, this allows for access --}}

    <div class="text-center">
        <img class="img-rounded" height="200px" src="{{$user->photo ? $user->photo->url : '/images/placeholder.jpg'}}" alt="">
    </div>
    <br>
    <div class="panel-body">
            <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $user->name) }}">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email', $user->email) }}">
                </div>

                <div class="form-group">
                    <label for="role_id">Role:</label>
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="">Choose An Option</option>
                        @foreach ($roles as $id => $name)
                            <option value="{{ $id }}" @selected(old('role_id', $user->role_id) == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="is_active">Status:</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="1" @selected(old('is_active', $user->is_active) == 1)>Active</option>
                        <option value="0" @selected(old('is_active', $user->is_active) == 0)>Offline</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Leave blank to keep current password">
                </div>

                <div class="form-group">
                    <label for="photo_id">Photo:</label>
                    <input type="file" name="photo_id" id="photo_id" class="form-control">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary col-sm-6">Update User</button>
                </div>
            </form>

            <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                onsubmit="return confirm('Delete this user?');">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <button type="submit" class="btn btn-danger col-sm-6">Delete User</button>
                </div>
            </form>
            
        </div>


    @include('includes.form_error')
       

@stop