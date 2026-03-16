


@if(Session::has('comment_message'))

    <div class="alert-success col-md-8">    
       <p class="text-center"> {{Session('comment_message')}} </p>
    </div>
@endif
