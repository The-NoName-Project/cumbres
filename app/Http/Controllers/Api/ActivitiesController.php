<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\User;
use App\Models\Roles;
use App\Models\Level;
use App\Models\School;
use App\Models\Sports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if que valida si el usuario es admin o no
        if (Auth::user()->role_id == 1) {
            $activities = Activities::all();
            //remplazar el id de la escuela por toda la informacion de la escuela
            foreach ($activities as $activity) {
                $user = User::find($activity->peopleone);
                $user2 = User::find($activity->peopletwo);
                $activity->people1 = $user;
                $activity->people2 = $user2;
                $sport = Sports::find($activity->sport);
                $activity->sport = $sport;
                $visor = User::find($activity->visor);
                $activity->visor = $visor;
            }

            return response()->json($activities, 200);
        } else {
            $activities = Activities::where('peopleone', Auth::user()->id)->orWhere('peopletwo', Auth::user()->id)->get();
            //remplazar el id de la escuela por toda la informacion de la escuela
            foreach ($activities as $activity) {
                $user = User::find($activity->peopleone);
                $user2 = User::find($activity->peopletwo);
                $activity->people1 = $user;
                $activity->people2 = $user2;
                $sport = Sports::find($activity->sport);
                $activity->sport = $sport;
                $visor = User::find($activity->visor);
                $activity->visor = $visor;
            }
            return response()->json($activities, 200);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'peopleone' => 'required',
            'peopletwo' => 'required',
            'sport' => 'required',
            'visor' => 'required',
            'scoreone' => 'required',
            'scoretwo' => 'required',
            'date' => 'required',
        ]);

        $activity = new Activities();
        $activity->peopleone = $request->peopleone;
        $activity->peopletwo = $request->peopletwo;
        $activity->sport = $request->sport;
        $activity->visor = $request->visor;
        $activity->scoreone = $request->scoreone;
        $activity->scoretwo = $request->scoretwo;
        $activity->date= $request->date;
        $activity->save();
        return response()->json($activity, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function show(Activities $activities)
    {
        if(auth()->user()->role_id == 1){
            return response()->json($activities, 200);
        }else{
            if($activities->peopleone == auth()->user()->id || $activities->peopletwo == auth()->user()->id){
                return response()->json($activities, 200);
            }else{
                return response()->json(['error' => 'No tienes permisos para ver esta actividad'], 404);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activities $activities)
    {
        $activities->update($request->all());
        return response()->json($activities, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activities $activities)
    {
        $activities->delete();
        return response()->json(null, 204);
    }
}
