<?php

namespace App\Support;

class Placeholder
{
    public static function image(int $w = 400, int $h = 300, string $label = 'No image'): string
    {
        return 'data:image/svg+xml;utf8,' . rawurlencode(
            "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"{$w}\" height=\"{$h}\">"
            . '<rect width="100%" height="100%" fill="#e9ecef"/>'
            . "<text x=\"50%\" y=\"50%\" text-anchor=\"middle\" dominant-baseline=\"middle\" "
            . "fill=\"#868e96\" font-family=\"sans-serif\" font-size=\"18\">{$label}</text>"
            . '</svg>'
        );
    }

    public static function avatar(): string
    {
        return self::image(100, 100, 'User');
    }
}