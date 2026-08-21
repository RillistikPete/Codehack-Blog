<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    protected $fillable = [
        'author',
        'email',
        'photo',
        'body',
        'is_active'
    ];

    public function comment() {
        return $this->belongsTo(Comment::class);
    }
}
