
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
                <form method="POST" action="{{ route('media.store') }}"
                    class="dropzone" id="media-dropzone"
                    enctype="multipart/form-data"
                    style="border:1px solid green;height:400px;border-radius:5px;">
                    @csrf
                </form>
            </span>
        </div>

@section('scripts')
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

@endsection

@stop