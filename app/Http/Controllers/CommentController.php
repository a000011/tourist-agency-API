<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function addComment(Request $request, int $tourId)
    {
        $validator = Validator::make($request->all(), [
            'commentContent' => 'required|min:3',
            'mark' => 'required|numeric|min:0|max:5',
        ]);
        if (!$validator->fails()) {
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

        return response()->json(
            [
                'code' => 400,
                'errors' => array_map(
                    function($errors){
                        foreach($errors as $key=>$value){
                            return $value;
                        }
                    },
                    $validator->errors()->toArray()
                )
            ],
            400
        );
    }
}
