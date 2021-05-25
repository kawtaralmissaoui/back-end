<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['login', 'register', 'logout']]);
    }
    public function  register(RegistrationFormRequest $request)
    {
        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->CIN = $request->CIN;
        $user->role = $request->role;
        $user->adresse = $request->adresse;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'user successfully registed',
            'user' => $user
        ], 201);
    }
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Email ou mot de passe est incorrect'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function me()
    {
        return response()->json(Auth::user());
    }
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ]);
    }

    public function change_password(Request $request )
    {
        $request->validate([
            'old_password'=>'required|min:6|max:13',
            'new_password'=>'required|min:6|max:13',
            'confirm_password'=>'required|same:new_password',
        ]);
        $current_user=User::find($request->id);
        //User::find(2);
       //Auth::user();
        if(Hash::check($request->old_password, $current_user->password))
        {
            $current_user->update([
                'password'=>bcrypt($request->new_password),
            ]);
            return 'modifier';
        }
        else
        {
            return 'erreur';
        }
    }
}
