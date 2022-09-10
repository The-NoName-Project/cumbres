<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if que verifica si el usuario ya contesto el cuestionario usando el campo results y el id del usuario
        if (Question::where('results', true)->where('user_id', Auth::user()->id)->exists()) {
            return response()->json(['message' => 'Ya fue contestado el cuestionario'], 200);
        } else {
            return response()->json(['message' => 'No has contestado el cuestionario'], 200);
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
        // dd(auth()->id());
        // dd($question);
        //el usuario solo puede contestar el cuestionario una vez al dia
        //obtenemos la fecha actual
        $date = date('Y-m-d');
        //verificamos si el usuario ya contesto el cuestionario
        if(Question::where('user_id', Auth::user()->id)->whereDate('created_at', $date)->exists()){
            return response()->json(['message' => 'Ya fue contestado el cuestionario, solo se puede contestar una vez'], 200);
        }else{
            $user_id = auth()->id();
            $request->validate([
                //q1 no puede pasar del numero 5
                'q1' => 'required|integer|max:5',
                'q2' => 'required|integer|max:5',
                'q3' => 'required|integer|max:5',
                'q4' => 'required|integer|max:5',
                'q5' => 'required|integer|max:5',
                'q6' => 'required|integer|max:5',
                'q7' => 'required|integer|max:5',
                'q8' => 'required|integer|max:5',
            ]);

            $question = new Question([
                'results' => 1,
                'q1' => $request->q1,
                'q2' => $request->q2,
                'q3' => $request->q3,
                'q4' => $request->q4,
                'q5' => $request->q5,
                'q6' => $request->q6,
                'q7' => $request->q7,
                'q8' => $request->q8,
                //total es el resultado de la suma de las respuestas
                'total' => $request->q1 + $request->q2 + $request->q3 + $request->q4 + $request->q5 + $request->q6 + $request->q7 + $request->q8,
                //obtenemos el id del usuario que esta logeado a traves del token
                'user_id' => $user_id,
            ]);

            $question->save();
            return response()->json(['message' => 'Encuesta contestada correctamente'], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
