<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
// for AdminPostsController@post to be able to find by slug
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;


class Post extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    }


    protected $fillable = [
        'category_id',
        'photo_id',
        'obj_url',
        'title',
        'body'
    ];


    public function user() {

        //look at it like: "$This post belongs to User"
        return $this->belongsTo('App\User');

    }

    public function photo() {
        
        return $this->belongsTo('App\Photo');

    }

    // public function obj_url() {

    //     return $this->belongsTo('App\Obj_Url');
    // }

    public function category() {

        return $this->belongsTo('App\Category');

    }

    public function comments() {

        return $this->hasMany('App\Comment');
    }

    public function photoPlaceholder() {

        return "/images/placeholder.jpg";
    }

}
