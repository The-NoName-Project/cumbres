<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\User;
use App\Models\School;
use App\Models\Level;
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
                'user_id' => $request->user_id,
            ]);

            $question->save();
            return response()->json(['message' => 'Encuesta contestada correctamente'], 201);
    }


    public function storeVisor(Request $request)
    {
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
                'user_id' => 'required|integer',
                'sport_id' => 'required|integer',
                'school_id' => 'required|integer',
                'gender' => 'required',
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
                'user_id' => $request->user_id,
                'sport_id' => $request->sport_id,
                'school_id' => $request->school_id,
                'level_id' => $request->level_id,
                'gender' => $request->gender
            ]);

            $question->save();
            return response()->json(['message' => 'Encuesta contestada correctamente'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //consulta para obtener los datos total y user_id de la tabla questions ordenados por total y sumando los resultados de cada uno que se repite pero no deben que tener el campo de school_id ni level_id ni gender ni sport_id llenos
        $data = Question::select('total', 'user_id')->where('school_id', null)->where('level_id', null)->where('gender', null)->where('sport_id', null)->orderBy('total', 'desc')->get();

        //recorre el array de datos
        foreach ($data as $item) {
            //si existe el campo user_id lo remplazamos por toda la informacion del usuario
            if (isset($item->user_id)) {
                $user = User::find($item->user_id);
                $item->user_id = $user;
                //si el usuario tiene el campo school_id lo remplazamos por toda la informacion de la escuela
                if (isset($user->school_id)) {
                    $school = School::find($user->school_id);
                    $user->school_id = $school;
                }
                //si el usuario tiene el campo level_id lo remplazamos por toda la informacion del nivel
                if (isset($user->level_id)) {
                    $level = Level::find($user->level_id);
                    $user->level_id = $level;
                }
            }
        }

        return response()->json($data, 200);

    }

    public function showVisor(Question $question)
    {
        //consulta para obtener los datos total y school_id de la tabla questions ordenados por total y sumando los resultados de cada escuela que se repite
        $data = \DB::table('questions')
            ->select(\DB::raw('sum(total) as total, school_id'))
            ->groupBy('school_id')
            ->orderBy('total', 'desc')
            ->get();

        //recorremos el array de datos

        foreach ($data as $item) {
            //si existe el campo school_id lo remplazamos por toda la informacion de la escuela
            if (isset($item->school_id)) {
                $school = School::find($item->school_id);
                $item->school_id = $school;
            }
        }

        //retornamos el array de datos

        return response()->json($data, 200);

    }

    public function showGender(Question $question)
    {
        //consulta para obtener los datos total, genero, user_id de la tabla questions ordenados por total
        $data = \DB::table('questions')
            ->select(\DB::raw('sum(total) as total, gender'))
            ->groupBy('gender')
            ->orderBy('total', 'desc')
            ->get();

        //recorremos el array de datos
        foreach ($data as $item) {
            //si existe el campo user_id lo remplazamos por toda la informacion del usuario
            if (isset($item->user_id)) {
                $user = User::find($item->user_id);
                $item->user_id = $user;
                //si el usuario tiene el campo school_id lo remplazamos por toda la informacion de la escuela
                if (isset($user->school_id)) {
                    $school = School::find($user->school_id);
                    $user->school_id = $school;
                }
            }
        }
        //retornamos el array de datos
        return response()->json($data, 200);
    }

    public function showTopUser(Question $question)
    {
        //consulta para obtener los datos total, user_id de la tabla questions ordenados por total solo retornando los 10 primeros resultados pero el usuario no debe ser visor ni admin
        $data = \DB::table('questions')
            ->select(\DB::raw('sum(total) as total, user_id'))
            ->where('user_id', '!=', 1)
            ->where('user_id', '!=', 2)
            ->where('user_id', '!=', 3)
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();
        //recorremos el array de datos
        foreach ($data as $item) {
            //si existe el campo user_id lo remplazamos por toda la informacion del usuario
            if (isset($item->user_id)) {
                $user = User::find($item->user_id);
                $item->user_id = $user;
                //si el usuario tiene el campo school_id lo remplazamos por toda la informacion de la escuela
                if (isset($user->school_id)) {
                    $school = School::find($user->school_id);
                    $user->school_id = $school;
                }
                //si el usuario tiene el campo level_id lo remplazamos por toda la informacion del nivel
                if (isset($user->level_id)) {
                    $level = Level::find($user->level_id);
                    $user->level_id = $level;
                }
            }
        }
        //retornamos el array de datos
        return response()->json($data, 200);
    }

    public function showTopSchool(Question $question)
    {
        //consulta para obtener los datos total, school_id de la tabla questions ordenados por total solo retornando los 10 primeros resultados
        $data = \DB::table('questions')
            ->select(\DB::raw('sum(total) as total, school_id'))
            //no se deben mostrar los resultados de la escuela sea null
            ->where('school_id', '!=', null)
            ->groupBy('school_id')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();
        //recorremos el array de datos
        foreach ($data as $item) {
            //si existe el campo school_id lo remplazamos por toda la informacion de la escuela
            if (isset($item->school_id)) {
                $school = School::find($item->school_id);
                $item->school_id = $school;
            }
        }
        //retornamos el array de datos
        return response()->json($data, 200);
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
