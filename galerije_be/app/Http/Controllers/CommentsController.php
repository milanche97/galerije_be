<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentsRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function store(CommentsRequest $request, $galleryId)
    {
        $newComment = new Comment();
        $newComment->body = $request->body;
        $newComment->user_id = optional(Auth::user())->id;
        $newComment->gallery_id = $galleryId;
        $newComment->save();

        $comment = Comment::with('user')->find($newComment->id);
        return $comment;
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return response()->json([
            'message' => 'Comment is deleted'
        ]);
    }}
