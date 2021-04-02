<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Http\Request;
use App\Models\User;

class SocieteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['AddSociete', 'register', 'logout']]);
    }
    public function  AddSociete(RegistrationFormRequest $request)
    {
        $user = new User();
        $user->patente = $request->patente;
        $user->nom_responsable = $request->nom_responsable;
        $user->prenom_responsable = $request->prenom_responsable;
        $user->nom_societe = $request->nom_societe;
        $user->statut_societe = $request->statut_societe;
        $user->email = $request->email;
        $user->CIN = $request->CIN;
        $user->role = 'proprietaire';
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->archive = $request->archive;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'societe successfully registed',
            'user' => $user
        ], 201);
    }

}
