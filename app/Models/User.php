<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Helpers\HasGravatar;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Gravatar
    use HasGravatar;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // removed empty string field here, idk what it was for
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'photo_id', 'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * always eager-load when retrieving this model
     */
    protected $with = ['role'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* Custom Functions */
    public function role() {
        return $this->belongsTo(Role::class);
    }
    
    public function photo() {
        return $this->belongsTo(Photo::class);
    }

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'administrator' && $this->is_active == 1;
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
