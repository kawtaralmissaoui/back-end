<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
class LocphController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['addLocP', 'register', 'logout']]);
    }
    public function  addLocP(RegistrationFormRequest $request)
    {
        $user = new User();
        $user->civilite = $request->civilite;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->CIN = $request->CIN;
        $user->role = 'locataire';
        $user->adresse = $request->adresse;
        $user->archive = 0;
        $user->password = bcrypt($request->password);
        //$user->image = $request->image->store('public');
        $user->save();
        return response()->json([
            'message' => 'locataire successfully registed',
            'user' => $user
        ], 201);
    }

    public function getLocPhyActif()
    {
        return  User::all()->where('role', '=', 'locataire')->where('archive', '=', '0');
    }
    public function getLocPhyArchive()
    {
        return  User::all()->where('role', '=', 'locataire')->where('archive', '=', '1');
    }
}
