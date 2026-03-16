<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Contact Email:</div>
                <div class="panel-body">
                    <p>From: <strong>{{$name}}</strong></p>
                    <p>{{$email}}</p>
                    <p>{{json_encode($msg)}}</p>
                    <hr/>
                </div>
            </div>
        </div>
    </div>
</div>