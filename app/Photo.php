<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('App\User', 'allowed_photos', 'photo_id', 'user_id');
    }
}
