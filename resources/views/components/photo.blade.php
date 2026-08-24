@props(['photo' => null, 'alt' => ''])

<img src="{{ $photo?->url ?? \App\Support\Placeholder::image() }}"
     alt="{{ $alt }}" {{ $attributes }}>