<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\School;
use App\Models\Level;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'app' => 'required|string',
            'apm' => 'required|string',
            'gender' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'role_id' => 'integer|required',
            'school_id' => 'integer',
            'level_id' => 'integer',
        ]);
        $user = new User([
            'name' => $request->name,
            'app' => $request->app,
            'apm' => $request->apm,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'school_id' => $request->school_id,
            'level_id' => $request->level_id,
            'active' => true,
        ]);
        $user->save();
        $user = User::find($user->id);
        //si existe el campo school_id
        if($user->school_id){
            $school = School::find($user->school_id);
            $user->school = $school;
        }
        //si existe el campo level_id
        if($user->level_id){
            $level = Level::find($user->level_id);
            $user->level = $level;
        }
        //si existe el campo role_id
        if($user->role_id){
            $role = Roles::find($user->role_id);
            $user->role = $role;
        }
        //create token
        $tokenResult = $user->createToken('Personal Access Token')->accessToken;
        return response()->json([
            'message' => 'Successfully created user!', 'user' => $user, 'token' => $tokenResult
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $user = User::find($user->id);
        //si existe el campo school_id
        if($user->school_id){
            $school = School::find($user->school_id);
            $user->school = $school;
        }
        //si existe el campo level_id
        if($user->level_id){
            $level = Level::find($user->level_id);
            $user->level = $level;
        }
        //si existe el campo role_id
        if($user->role_id){
            $role = Roles::find($user->role_id);
            $user->role = $role;
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        //recuperar el usuario desde el token
        $user = Auth::user()->id;
        $user = User::find($user);
        //si existe el campo school_id
        if($user->school_id){
            $school = School::find($user->school_id);
            $user->school = $school;
        }
        //si existe el campo level_id
        if($user->level_id){
            $level = Level::find($user->level_id);
            $user->level = $level;
        }
        //si existe el campo role_id
        if($user->role_id){
            $role = Roles::find($user->role_id);
            $user->role = $role;
        }
        return response()->json($user);

    }
}


