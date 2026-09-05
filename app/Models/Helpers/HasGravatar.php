<?php

namespace App\Models\Helpers;

trait HasGravatar
{
    public function getGravatarAttribute(): string
    {
        $hash = hash('sha256', strtolower(trim($this->gravatarEmail() ?? '')));

        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=128";
    }

    protected function gravatarEmail(): ?string
    {
        return $this->email;
    }

    public function getAvatarAttribute(): string
    {
        return $this->avatarPhotoUrl() ?? $this->gravatar;
    }

    protected function avatarPhotoUrl(): ?string
    {
        return $this->photo?->url;
    }
}