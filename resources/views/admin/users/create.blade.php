@extends('layouts.admin')

@section('content')

    <h1>Create User</h1>

    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="role_id">Role:</label>
            <select name="role_id" id="role_id" class="form-control">
                <option value="">Choose An Option</option>
                @foreach ($roles as $id => $name)
                    <option value="{{ $id }}" @selected(old('role_id') == $id)>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="is_active">Status:</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" @selected(old('is_active') == 1)>Active</option>
                <option value="0" @selected(old('is_active', 0) == 0)>Offline</option>
            </select>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="form-group">
            <label for="photo_id">File:</label>
            <input type="file" name="photo_id" id="photo_id" class="form-control">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create User</button>
        </div>
    </form>

    @include('includes.form_error')

@stop