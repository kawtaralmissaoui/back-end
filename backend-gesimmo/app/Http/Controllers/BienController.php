<?php

namespace App\Http\Controllers;
use App\Http\Requests\BienRequest;
use Illuminate\Http\Request;
use App\Models\Bien;
class BienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['AddBien', 'register', 'logout']]);
    }
    public function  AddBien(BienRequest $request)
    {
        $bien = new Bien();
        $bien->adresse = $request->adresse;
        $bien->surface = $request->surface;
        $bien->statut = $request->statut;
        $bien->loyer_mensuel = $request->loyer_mensuel;
        $bien->syndic = $request->syndic;
        $bien->taxe_habitation = $request->taxe_habitation;
        $bien->archive = $request->archive;
        $bien->nbr_piece = $request->nbr_piece;
        $bien->equipement = $request->equipement;
        $bien->ascenseur = $request->ascenseur;
        $bien->etage = $request->etage;
        $bien->user_id = $request->user_id;
        $bien->save();
        return response()->json([
            'message' => 'bien successfully registed',
            'user' => $bien
        ], 201);
    }
}
