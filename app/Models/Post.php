<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;
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

    // accessor
    public function getObjUrlAttribute($value): ?string
    {
        // value is the stored column
        if ($value) {
            return $value;
        }

        $name = $this->photo?->getRawOriginal('file');

        return $name ? Storage::disk('s3')->url($name) : null;
    }

    /*
    for understanding above accessor:
    Eloquent resolves it by naming convention:

    $post->obj_url
      → Model::__get('obj_url')
      → getAttribute('obj_url')
      → looks for "get" . Str::studly('obj_url') . "Attribute"
      → getObjUrlAttribute()  ← found, so call it

    if you ever need the untouched database value, $post->getRawOriginal('obj_url') bypasses the accessor
    
    laravel 9 added this syntax equivalent:
    protected function objUrl(): Attribute
    {
        return Attribute::get(fn ($value) => $value ?: // derive );
    }
    */

    //And if you ever need the untouched database value, $post->getRawOriginal('obj_url')
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
