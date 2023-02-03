<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleriesController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->query('user_id', '');
        $term = $request->query('term', '');
        $galleries = Gallery::searchByTerm($term, $user_id)->latest()->paginate(10);

        return response()->json($galleries);
    }

    public function show($id)
    {
        $gallery = Gallery::with(['images', 'user', 'comments', 'comments.user'])->findOrFail($id);

        return $gallery;
    }
    public function store(GalleryRequest $request)
    {
        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->user_id = auth()->user()->id;
        $gallery->save();

        $imgs = [];
        foreach ($request->images as $img) {
            $imgs[] = new Image($img);
        }
        $gallery->images()->saveMany($imgs);

        return $this->show($gallery->id);
    }

    public function update(GalleryRequest $request, $id)
    {
        $gallery = Gallery::find($id);
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->user_id = auth()->user()->id;
        $gallery->save();

        $gallery->images()->delete();
        $imgs = [];
        foreach (request('images') as $img) {
            $imgs[] = new Image($img);
        }
        $gallery->images()->saveMany($imgs);

        return $this->show($gallery->id);
    }
    // public function store(GalleryRequest $request)
    // {
    //     $gallery = new Gallery();
    //     $gallery->title = $request->title;
    //     $gallery->description = $request->description;
    //     $gallery->user_id = optional(Auth::user())->id;
    //     $gallery->save();

    //     foreach ($request->urls as $url) {
    //         $image = new Image();
    //         $image->url = $url;
    //         $image->gallery_id = $gallery->id;
    //         $image->save();
    //     }
    //     return $this->show($gallery->id);
    // }
    // public function update(GalleryRequest $request, $id)
    // {
    //     $gallery = Gallery::find($id);
    //     $gallery->title = $request->title;
    //     $gallery->description = $request->description;
    //     $gallery->user_id = auth()->user()->id;
    //     $gallery->save();

    //     $gallery->images()->delete();
    //     foreach ($request->urls as $url) {
    //         $image = new Image();
    //         $image->url = $url;
    //         $image->gallery_id = $gallery->id;
    //         $image->save();
    //     }

    //     return $this->show($gallery->id);
    // }

    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }
}
