
@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
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
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script>
    Dropzone.options.mediaDropzone = {
        paramName: 'file',                 // must match $request->file('file')
        maxFilesize: 5,                    // MB
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        dictDefaultMessage: 'Drop images here or click to browse',

        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },

        success: function (file, response) {
            file.previewElement.classList.add('dz-success');
        },

        error: function (file, message) {
            alert(typeof message === 'string' ? message : (message.message || 'Upload failed'));
        },

        queuecomplete: function () {
            setTimeout(() => window.location = '{{ route('media.index') }}', 800);
        }
    };
</script>
@endsection