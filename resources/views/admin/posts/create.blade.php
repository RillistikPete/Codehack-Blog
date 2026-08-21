@extends('layouts.admin')

@section('content')
    
    @include('includes.markdown-editor')

    <h1>Create Post</h1>

    <div class="row">
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class='form-group'>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
            </div>
            <div class='form-group'>
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" class="form-control" style="width:155px;">
                    <option value="">Choose Category</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}" @selected(old('category_id') == $id)>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class='form-group'>
                <label for="photo_id">Photo:</label>
                <input type="file" name="photo_id" id="photo_id" class="form-control">
            </div>
            <div class='form-group'>
                <label for="body">Description:</label>
                <textarea name="body" id="markdown-editor" class="form-control" rows="20">{{ old('body') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
    
    <div class="row">
        @include('includes.form_error')
    </div>

@endsection