<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Tour as TourModel;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{
    private const ADMIN_ROLE = 'admin';

    private const USER_ROLE = 'user';

    private const HOST = 'http://10.0.2.2:8000';

    public function addTour(Request $request)
    {

        if ($request->user()->role === self::ADMIN_ROLE) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required'
            ]);
            if (!$validator->fails()) {
                $newTour = new TourModel();
                $newTour->title = $request->title;
                $newTour->description = $request->description;
                $newTour->img = $request->img;

                $newTour->save();

                return response()->json($newTour, 201);
            }

            return response()->json($validator->errors(), 400);
        }

        return response()->json(
            [
                "status" => 403,
                "errors" => ["Unauthorized"]
            ],
            403
        );
    }

    public function getTour($id)
    {
        $tour = TourModel::find($id);
        $marksSum = 0;
        if ($tour !== null) {
            foreach ($tour->comments as $comment) {
                $comment->user;
                $marksSum += $comment->mark;
                if ($comment->user->avatar == null) {
                    if ($comment->user->role === self::USER_ROLE) {
                        $comment->user->avatar = self::HOST . '/storage/avatars/default/user.png';
                    } elseif ($comment->user->role === self::ADMIN_ROLE) {
                        $comment->user->avatar = self::HOST . '/storage/avatars/default/admin.png';
                    }
                }
            }

            $tour->mark = round($marksSum / count($tour->comments), 2);

            return $tour;
        }

        return response()->json(['status' => 'not found'], 404);
    }

    public function getTours()
    {
        $tours = TourModel::all();

        foreach ($tours as $tour){
            $comments = Comment::where('tour_id', $tour->id)->get();
            $marksSum = 0;
            foreach ($comments as $comment) {
                $marksSum += $comment->mark;
            }

            $tour->mark = round($marksSum / count($comments), 2);
        }

        return $tours;
    }

    public function deleteTour($id)
    {
        $tour = TourModel::find($id);

        if ($tour !== null) {
            return $tour->delete();
        }

        return response()->json(['status' => 'not found'], 404);
    }
}
