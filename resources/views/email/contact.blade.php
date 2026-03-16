@extends('layouts.blog-home')
@section('content')
<div class="container">
    <div class="row">
        @include('flash::message')
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Contact Me: Send an Email</div>
                <div class="panel-body">
                    <form method="POST" action="{{route('contact.submit')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="msg">Message</label>
                            <textarea style="height:100px;" name="msg" class="form-control" required></textarea>
                        </div>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary float-right" value="Submit" />
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
