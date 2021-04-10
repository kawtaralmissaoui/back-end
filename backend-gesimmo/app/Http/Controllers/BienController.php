<?php

namespace App\Http\Controllers;
use App\Http\Requests\BienRequest;
use Illuminate\Http\Request;
use App\Models\Bien;
class BienController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['AddBien', 'register', 'logout']]);
    }
    public function  AddBien(BienRequest $request)
    {
        $bien = new Bien();
        $bien->identifiant = $request->identifiant;
        $bien->adresse = $request->adresse;
        $bien->surface = $request->surface;
        $bien->statut = 'libre';
        $bien->loyer_mensuel = $request->loyer_mensuel;
        $bien->syndic = $request->syndic;
        $bien->code_postal = $request->code_postal;
        $bien->taxe_habitation = $request->taxe_habitation;
        $bien->archive = 0;
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
    public function getBienActif()
    {
        return  Bien::all()->where('archive', '=', '0');
    }
    public function getBienArchive()
    {
        return  Bien::all()->where('archive', '=', '1');
    }
    public function countbien()
    {
        return  Bien::all()->count();
    }

    public function getbienById($id){
        $bien =  Bien::find($id);
        return $bien;
    }

    public function archiverBien($id){
        $bien =  Bien::find($id);
        if($bien)
        {
            $bien->archive=1;
            $bien->save();
        }
        return response()->json([
            'message' => 'bien archive',
        ], 201);
    }

    public function updatebien(Request $request)
    {
        $bien = Bien::find($request->id);

        $bien->identifiant = $request->identifiant;
        $bien->adresse = $request->adresse;
        $bien->surface = $request->surface;
        $bien->loyer_mensuel = $request->loyer_mensuel;
        $bien->syndic = $request->syndic;
        $bien->taxe_habitation = $request->taxe_habitation;
        $bien->nbr_piece = $request->nbr_piece;
        $bien->equipement = $request->equipement;
        $bien->ascenseur = $request->ascenseur;
        $bien->etage = $request->etage;
        $bien->user_id = $request->user_id;
        $bien->code_postal = $request->code_postal;
        $bien->save();
        return response()->json([
            'message' => 'proprietaire has succesfully updated ',
            'user' =>  $bien
        ], 201);
    }
}
