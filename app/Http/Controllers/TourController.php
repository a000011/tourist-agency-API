<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour as TourModel;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{
    private static $ADMIN_ROLE = 'admin';

    public function addTour(Request $request){

        if($request->user()->role === self::$ADMIN_ROLE){
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required'
            ]);
            if(!$validator->fails()){
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

    public function getTour($id){
        $tour = TourModel::find($id);

        if($tour !== null){
            return $tour;
        }

        return response()->json(['status' => 'not found'], 404);
    }

    public function getTours(){
        return TourModel::all();
    }

    public function deleteTour($id){
        $tour = TourModel::find($id);

        if($tour !== null){
            return $tour->delete();
        }

        return response()->json(['status' => 'not found'], 404);
    }
}
