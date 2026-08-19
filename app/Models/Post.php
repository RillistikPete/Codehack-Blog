<?php

namespace App\Models;

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
        return $this->belongsTo(User::class);
    }

    public function photo() {
        return $this->belongsTo(Photo::class);
    }

    // public function obj_url() {

    //     return $this->belongsTo('App\Obj_Url');
    // }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function photoPlaceholder() {
        return "/images/placeholder.jpg";
    }

}
