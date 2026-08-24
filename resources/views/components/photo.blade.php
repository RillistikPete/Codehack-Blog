@props(['photo' => null, 'url' => null, 'alt' => ''])

<img src="{{ $url ?? $photo?->url ?? \App\Support\Placeholder::image() }}"
     alt="{{ $alt }}" {{ $attributes }}>