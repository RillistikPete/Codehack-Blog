@extends('layouts.blog-home')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$details['title']}}</div>
                <div class="panel-body">
                    <p>{{$details['body']}}</p>
                    <h5>Thank you</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
