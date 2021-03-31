<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
class ProprietaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['AddProprietaire', 'register', 'logout']]);
    }
    public function  AddProprietaire(RegistrationFormRequest $request)
    {
        $user = new User();
        $user->civilite = $request->civilite;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->CIN = $request->CIN;
        $user->role = 'proprietaire';
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->archive = $request->archive;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'proprietaire successfully registed',
            'user' => $user
        ], 201);
    }
}
