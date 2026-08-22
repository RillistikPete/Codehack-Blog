@extends('layouts.admin')

@section('content')

    @include('includes.markdown-editor')

    <h1>Edit Post</h1>

    <div class="row">
        <div class="col-sm-8">
            <img src="{{ $post->photo ? $post->photo->url : $post->photoPlaceholder() }}"
                 alt="" class="img-responsive">
        </div>

        <div class="col-sm-8">

            <form method="POST" action="{{ route('posts.update', $post->id) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <!-- What Laravel actually renders in the browser with this patch directive-->
                <!-- <form action="/profile" method="POST">
                        <input type="hidden" name="_method" value="PATCH">
                    </form> -->

                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ old('title', $post->title) }}">
                </div>

                <div class="form-group">
                    <label for="category_id">Category:</label>
                    <select name="category_id" id="category_id" class="form-control">
                        @foreach ($categories as $id => $name)
                            <option value="{{ $id }}"
                                @selected(old('category_id', $post->category_id) == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="photo_id">Photo:</label>
                    <input type="file" name="photo_id" id="photo_id" class="form-control">
                </div>

                <div class="form-group">
                    <label for="body">Description:</label>
                    <textarea name="body" id="markdown-editor" class="form-control" rows="20">{{ old('body', $post->body) }}</textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

        </div>
    </div>

    <div class="row">
        @include('includes.form_error')
    </div>

@endsection