@extends('layouts.admin')


@section('content')
    

    <h1>Categories</h1>
    <hr>
    <div class="col-sm-6">

        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create Category</button>
            </div>
        </form>
    </div>

    <div class="col-sm-6">

        @if($categories)
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Created Date</th>
                </tr>
            </thead>
        <tbody>

            @foreach ($categories as $categ)
                <tr>
                    <td>{{$categ->id}}</td>
                <td><a href="{{route('categories.edit', $categ->id)}}">{{$categ->name}}</a></td>
                    <td>{{$categ->created_at ? $categ->created_at->diffForHumans() : 'No date'}}</td>
                </tr>
            @endforeach
        
        </tbody>
        </table>

        @endif

    </div>










@endsection