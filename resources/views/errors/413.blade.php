@extends('layouts.blog-home')

@section('content')
    <h1>File too large 😟</h1>
    <p>That upload exceeded the maximum request size. Please choose a file under 5 MB.</p>
    <p><a href="{{ url()->previous() }}">Go back</a></p>
@endsection