<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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

    // public function roles(){

    //     return $this->belongsToMany('App\Role');
    // }

    // public function assignRole(Role $role) {

    //     return $this->roles()->attach($role);
    // }

    // public function isActive() {

    //     return $this->belongsTo('App\Role');
    // }
    
    public function photo() {
        return $this->belongsTo(Photo::class);
    }

    // public function setPasswordAttribute($password) {
    //     if(!empty($password)){
    //         $this->attributes['password'] = bcrypt($password);
    //     }
    // }

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'administrator' && $this->is_active == 1;
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function getGravatarAttribute() {
        $email = strtolower(trim($this->email));
        $hash = md5(strtoLower(trim($this->attributes['email']))) . "";
        return "https://www.gravatar.com/avatar/$hash";
    }
}
