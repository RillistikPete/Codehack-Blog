<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Helpers\HasGravatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentReply extends Model
{
    use HasFactory;
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

    // added with migration add_user_id_to_comments_and_replies
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function gravatarEmail(): ?string
    {
        return $this->user?->email ?? $this->email;
    }
}
