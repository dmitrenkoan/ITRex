<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PublicationPhoto;

class UploadController extends Controller
{
    public function upload(Request $request, $publicationId) {
        $publicationPhoto = null;

        $this->validate($request, [
            'image_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image_file');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $baseDir = '/app';
        $pathDir = '/images';
        $destinationPath = storage_path($baseDir.$pathDir);
        $image->move($destinationPath, $input['imagename']);

        $publicationPhoto = new PublicationPhoto();
        $publicationPhoto->path = $pathDir.'/'.$input['imagename'];
        $publicationPhoto->publication_id = $publicationId;
        $publicationPhoto->save();
        return $publicationPhoto;
    }
}
