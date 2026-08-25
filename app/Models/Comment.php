<?php

namespace App\Models;
use App\Models\Helpers\HasGravatar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    use HasGravatar;

    // With post_id in fillable, a crafted POST to that admin endpoint could move a comment onto a different post
    protected $fillable = [
        'author',
        'email',
        'photo',
        'body',
        'is_active'
    ];

    public function replies() {
        return $this->hasMany(CommentReply::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
