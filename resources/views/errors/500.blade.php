@extends('layouts.blog-home')

@section('content')
    <h1 class="text-center">Server error...we're sorry about that.</h1>
    <p><a href="{{ url()->previous() }}">Go back</a></p>
@stop