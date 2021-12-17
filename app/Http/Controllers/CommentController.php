<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function addComment(Request $request, int $tourId)
    {
        if (Comment::where('user_id', $request->user()->id)->where('tour_id', $tourId)->first()) {
            return response()->json(
                [
                    'code' => 403,
                    'errors' => [
                        'comment' => 'you have already created comment on this tour page'
                    ]
                ],
                403
            );
        }

        $newComment = new Comment();
        $newComment->user_id = $request->user()->id;
        $newComment->tour_id = $tourId;
        $newComment->content = $request->commentContent;
        $newComment->mark = $request->mark;

        $newComment->save();

        return response(null, 201);
    }
}
