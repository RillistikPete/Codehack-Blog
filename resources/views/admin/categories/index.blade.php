@extends('layouts.admin')


@section('content')
    

    <h1>Categories</h1>
    <hr>
    <div class="col-sm-6">

        {!! Form::open(['method'=>'POST', 'action'=>'AdminCategoriesController@store']) !!}
        <div class='form-group'>
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
        {!! Form::submit('Create Category', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
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