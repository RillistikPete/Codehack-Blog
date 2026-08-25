<?php

namespace App\Models\Helpers;

trait HasGravatar
{
    public function getGravatarAttribute(): string
    {
        $hash = md5(strtolower(trim($this->email ?? '')));

        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=128";
    }
}