<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicationTag extends Model
{
    protected $fillable = ['tag', 'publication_id'];
    public $timestamps = false;

    public function tags() {
        return $this->belongsToMany('App\Publication', 'publication_tags');
    }
}
