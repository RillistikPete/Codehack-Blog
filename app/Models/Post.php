<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;


class Post extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;
    use HasFactory;

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

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function photoPlaceholder() {
        return "/images/placeholder.jpg";
    }

    // accessor
    public function getObjUrlAttribute($value): ?string
    {
        return $value ?: $this->photo?->url;
    }

    /*
    for understanding getObjUrlAttribute accessor:
    The obj_url column stays null and the URL is computed on read. It remains a real column purely as an override.

    Eloquent resolves it by naming convention:

    $post->obj_url
      → Model::__get('obj_url')
      → getAttribute('obj_url')
      → looks for "get" . Str::studly('obj_url') . "Attribute"
      → getObjUrlAttribute()  ← found, so call it

    if you ever need the untouched database value, $post->getRawOriginal('obj_url') bypasses the accessor
    
    laravel 9 equivalent:
    protected function objUrl(): Attribute
    {
        return Attribute::get(fn ($value) => $value ?: // derive );
    }
    */


    // For CommonMark texteditor:
    public function getBodyHtmlAttribute(): string
    {
        return Str::markdown($this->body ?? '', [
            'html_input'         => 'strip', // prevent script embed
            'allow_unsafe_links' => false,   // block javascript: urls
        ]);
    }

    // allows for {{ $post->excerpt }} to output a short summary of post
    public function getExcerptAttribute(): string
    {
        return Str::limit(trim(strip_tags($this->body_html)), 300);
    }

}
