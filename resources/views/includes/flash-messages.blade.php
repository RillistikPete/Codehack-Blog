
@php
    $flashes = [
        'success' => 'success',
        'info'    => 'info',
        'warning' => 'warning',
        'error'   => 'danger',
    ];
@endphp

@foreach ($flashes as $key => $class)
    @if (session($key))
        <div class="alert alert-{{ $class }} alert-dismissible" id="flashdiv">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session($key) }}
        </div>
    @endif
@endforeach