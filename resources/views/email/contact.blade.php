@extends('layouts.blog-home')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Contact Me: Send an Email</div>
            <div class="panel-body">

                <form method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <x-honeypot />

                    <div class="form-group @error('name') has-error @enderror">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('email') has-error @enderror">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('msg') has-error @enderror">
                        <label for="msg">Message</label>
                        <textarea name="msg" id="msg" class="form-control"
                                  style="height:150px;" required>{{ old('msg') }}</textarea>
                        @error('msg')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
