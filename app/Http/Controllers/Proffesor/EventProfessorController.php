<?php

namespace App\Http\Controllers\proffesor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventProfessorController extends Controller
{


    function latestEvents(Request $request){

        $professor = $request->user();
        if (!$professor) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        if($professor->type != 1){
            return response()->json(['error' => 'User is not a professor'], 400);
        }//end if

        return response()->json(
            Event::orderByDesc("created_at")->limit(10)->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'name' => $event->title,
                        'content' => $event->content,
                        'path' => $event->image,
                        'created_at' => $event->created_at,
                        'updated_at' => $event->updated_at,
                    ];
                })
        );

    }//end latestEvents

}
