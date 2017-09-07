<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = ['title', 'text'];

    public function tags() {
        return $this->hasMany('App\PublicationTag');
    }

    public function photos() {
        return $this->hasOne('App\PublicationPhoto');
    }
}
