<?php

namespace App\Http\Controllers;
use App\Http\Requests\FactureRequest;
use Illuminate\Http\Request;
use App\Models\Facture;
class ChargeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['addCharge', 'register', 'logout']]);
    }
    public function  addCharge(FactureRequest $request)
    {
        $Facture = new Facture ();
        $Facture->date_paiement = $request->date_paiement;
        //$Facture->etat_paiement = $request->etat_paiement ;
        $Facture->type = 'charge' ;
        //$Facture->statut = $request->statut ;
        //$Facture->loyer_mensuel = $request->loyer_mensuel;
        //$Facture->syndic = $request->syndic;
        //$Facture->taxe = $request->taxe;
        $Facture->description = $request->description;
        $Facture->montant = $request->montant;
        $Facture->nbt_relance = $request->nbt_relance;
        $Facture->save();
        return response()->json([
            'message' => 'Facture  successfully registed',
            'Facture ' => $Facture
        ], 201);
    }
    public function getchargeById($id){
        $Facture =  Facture::where('type', '=', 'charge')->find($id);
        return $Facture;
    }
    public function getChargeActif()
    {
        return  Facture::all()->where('type', '=', 'charge');
    }
}
