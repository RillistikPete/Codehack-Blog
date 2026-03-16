
@extends('layouts.admin')



{{-- this way, styles and scripts are only run on this page --}}
@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/basic.min.css">

@endsection

@section('content')


    <h1>Upload Media</h1>
    <hr>
        <h3 class="text-center">Click box or drag files into box to upload</h3>
        <div class="col-lg-12">
            <span class="border border-success">
                {!! Form::open(['method'=>'POST', 'action'=>'AdminMediaController@store', 'class'=>'dropzone', 'style'=>'border:1px solid green;height:400px;border-radius:5px;', 'rows'=>400]) !!}
            
                {!! Form::close() !!}
            </span>
        </div>

@section('scripts')
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

@endsection

@stop