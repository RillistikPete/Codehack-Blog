@extends('layouts.admin')


@section('content')
    

    <h1>Categories</h1>
    <hr>
    <div class="col-sm-6">
        <form method="POST" action="{{ route('categories.update', $category->id) }}">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $category->name) }}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary col-sm-6">Update Category</button>
            </div>
        </form>

        <form method="POST" action="{{ route('categories.destroy', $category->id) }}"
            onsubmit="return confirm('Delete this category?');">
            @csrf
            @method('DELETE')
            <div class="form-group">
                <button type="submit" class="btn btn-danger col-sm-6">Delete Category</button>
            </div>
        </form>
    </div>

    <div class="col-sm-6">
    </div>










@endsection