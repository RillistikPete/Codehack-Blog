@props(['photo' => null, 'url' => null, 'alt' => '', 'fallback' => true])

@php
    $src = $url ?? $photo?->url ?? ($fallback ? \App\Support\Placeholder::image() : null);
@endphp

@if ($src)
    <img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes }}>
@endif