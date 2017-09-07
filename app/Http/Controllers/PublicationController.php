<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publication;
use App\PublicationTag;
use Illuminate\Support\Facades\Storage;
use App\PublicationPhoto;
use App\Http\Controllers\UploadController;

class PublicationController extends Controller
{

    public function index(Request $request)
    {
        $searchRequest = $request->tagSearch;
        $paginateCount = 10;
        $publications = null;
        if($searchRequest) {
            $publications = Publication::whereHas('tags' , function($query) use ($searchRequest)
            {
                $query->where('tag', '=' , $searchRequest);
            })->with('tags', 'photos')->paginate($paginateCount);
        } else {
            $publications = Publication::with('tags', 'photos')->paginate($paginateCount);
        }
        return $publications;
    }

    public function show($id)
    {
        $publication = Publication::with('tags', 'photos')->find($id);

        return $publication;
    }

    public function create(Request $request)
    {
        $arRequest = $request->all();
        $publication = Publication::create($arRequest);
        if(!empty($arRequest['tags'])) {
            foreach($arRequest['tags'] as $tag) {
                $tagResult = PublicationTag::create([
                    'tag' => $tag,
                    'publication_id' => $publication->id
                ]);
                $publication->tags[] = $tagResult;
            }
        }
        if(!empty($arRequest['image_file'])) {
            $photo = new UploadController();
            $publication->photos = $photo->upload($request, $publication->id);
        }
        return response()->json($publication, 201);

    }

    public function update(Request $request, $id)
    {
        $arRequest = $request->all();
        $publication = Publication::with('photos')->findOrFail($id);
        Storage::delete($publication->photos->path);
        $publication->update($arRequest);
        $publication->tags()->delete();
        $publication->photos()->delete();
        if(!empty($arRequest['tags'])) {
            foreach($arRequest['tags'] as $tag) {
                $tagResult = PublicationTag::create([
                    'tag' => $tag,
                    'publication_id' => $publication->id
                ]);
                $publication->tags[] = $tagResult;
            }
        }
        if(!empty($arRequest['image_file'])) {
            $photo = new UploadController();
            $publication->photos = $photo->upload($request, $publication->id);
        }
        return response()->json($publication, 200);

    }

    public function delete($id)
    {
        $publication = Publication::with('tags', 'photos')->findOrFail($id);
        Storage::delete($publication->photos->path);
        $publication->tags()->delete();
        $publication->photos()->delete();
        $publication->delete();
        return response()->json(null, 204);
    }
}
