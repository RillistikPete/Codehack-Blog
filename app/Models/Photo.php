<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $fillable = ['file'];

    public function getUrlAttribute(): string
    {
        return Storage::disk('s3')->url($this->file);
    }
}