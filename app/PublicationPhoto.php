<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PublicationPhoto extends Model
{
    protected $fillable = ['publication_id', 'path'];

    public static function upload(Request $request, $publicationId)
    {
        $publicationPhoto = null;




        //$file = $request->file('image_file');
        $filename = time();
        $path = $request->image_file->storeAs('images', $filename.'.jpg');
        if($filename)
        {
            $publicationPhoto = new PublicationPhoto();
            $publicationPhoto->path = $path;
            $publicationPhoto->publication_id = $publicationId;
            $publicationPhoto->save();
        }
        return $publicationPhoto;
    }

    public function photos() {
        return $this->belongsToMany('App\Publication', 'publication_photos');
    }
}
