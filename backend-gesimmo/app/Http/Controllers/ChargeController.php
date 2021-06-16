<?php

namespace App\Http\Controllers;
use App\Http\Requests\FactureRequest;
use Illuminate\Http\Request;
use App\Models\Charge;
use Illuminate\support\Facades\DB;
class ChargeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['addCharge', 'register', 'logout']]);
    }
    public function  addCharge(Request $request)
    {
        $Charge = new Charge ();
        $Charge->date_paiement = $request->date_paiement;
        //$Facture->etat_paiement = $request->etat_paiement ;
        //$Charge->type = 'charge' ;
        //$Facture->statut = $request->statut ;
        //$Facture->loyer_mensuel = $request->loyer_mensuel;
        //$Facture->syndic = $request->syndic;
        //$Facture->taxe = $request->taxe;
        $Charge->description = $request->description;
        $Charge->montant_total = $request->montant_total;
        //$Charge->nbt_relance = $request->nbt_relance;
        $Charge->bien_id = $request->bien_id;
        $Charge->save();
        return response()->json([
            'message' => 'Facture  successfully registed',
            'Facture ' => $Charge
        ], 201);
    }
    public function getchargeById($id){
        $Charge =  Charge::find($id);
        return $Charge;
    }
    public function getChargeActif()
    {
        return  Charge::all();
    }

    public function searchcharge($search)
    {
        $Charge=DB::table('charges')
        ->where('date_paiement','like','%'.$search.'%')
        ->orwhere('description','like','%'.$search.'%')
        ->orwhere('montant_total','like','%'.$search.'%')
        ->get();
        return $Charge;
    }
}
