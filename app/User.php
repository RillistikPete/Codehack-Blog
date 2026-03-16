<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'photo_id', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {

        return $this->belongsTo('App\Role');
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

        return $this->belongsTo('App\Photo');
    }

    // public function setPasswordAttribute($password) {
    //     if(!empty($password)){
    //         $this->attributes['password'] = bcrypt($password);
    //     }
    // }

    public function isAdmin() {
        if($this->role->name == "administrator" && $this->is_active == 1){
            return true;
        }
            return false;
    }

    public function posts() {

        return $this->hasMany('App\Post');


    }

    public function getGravatarAttribute() {

        $hash = md5(strtoLower(trim($this->attributes['email']))) . "";
        return "http://www.gravatar.com/avatar/$hash";
    }

}
