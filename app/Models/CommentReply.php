<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Helpers\HasGravatar;

class CommentReply extends Model
{
    use HasGravatar;

    protected $fillable = [
        'user_id',
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
