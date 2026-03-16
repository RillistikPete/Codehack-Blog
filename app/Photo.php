<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //protected $placehold = '/images/placeholder.jpg';

    //ACCESSOR:
    protected $uploads = '/images/';

    protected $fillable = ['file'];

    public function getFileAttribute($photo){
        return $this->uploads . $photo;
    }

    // public function showPlaceholdPhoto($photo) {
    //     return $this->placehold;
    // }
    public function lfmPhotosFolder() {
        return public_path() . '/images/2/picsThatAreCool';
    }
}
