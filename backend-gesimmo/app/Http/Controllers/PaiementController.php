<?php

namespace App\Http\Controllers;
use App\Http\Requests\FactureRequest;
use Illuminate\Http\Request;
use App\Models\Facture;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Relance;
use App\Mail\Paiement;


class PaiementController extends Controller
{
    public function __construct()
    {
<<<<<<< HEAD
     //   $this->middleware('auth:api', ['except' => ['addPaiement', 'register', 'logout']]);
=======
        //$this->middleware('auth:api', ['except' => ['addPaiement', 'register', 'logout']]);
>>>>>>> 1bc921891cdc31284c8ddb48456ab5cb9e3a96c4
    }
    public function  addPaiement(FactureRequest $request)
    {
        $Facture = new Facture ();
        $Facture->date_paiement = $request->date_paiement;
       // $Facture->etat_paiement = $request->etat_paiement ;
        $Facture->type = $request->type ;
        $Facture->loyer_mensuel = $request->loyer_mensuel;
        $Facture->syndic = $request->syndic;
        $Facture->taxe = $request->taxe;
        $Facture->archive = $request->archive;
        $Facture->nbt_relance = $request->nbt_relance;
        $Facture->location_id = $request->location_id;
        $Facture->save();
        return response()->json([
            'message' => 'Facture  successfully registed',
            'Facture ' => $Facture
        ], 201);
    }

    public function updateFacture(Request $request){
        $facture = Facture::with('location.user')->find($request->id);
        $montant_recu = $request->montant_recu;


       // $facture->syndic=$request->syndic;
       // echo $facture->syndic;
     //   $facture->loyer_mensuel = $request->loyer_mensuel;

        //$montantTotale = $facture->loyer_mensuel + $facture->syndic;
           $currentDate = Carbon::now();


           if($montant_recu<$facture->montant_total)
               {
                $date1 = new Carbon($facture->mois_paiement);
                $date2 = new Carbon($facture->mois_paiement);
                $date3 = new Carbon($facture->mois_paiement);
                $date1->addDays(5);
                $date2->addDays(13);
                $date3->addDays(20);
                  if(($currentDate=$date1) || ($currentDate=$date2) || ($currentDate=$date3))
                  {// $facture->etat_paiement="Impayé";
                    $facture->nbt_relance = $facture->nbt_relance +1;
                    $facture->nbr_relance_total = $facture->nbr_relance_total + 1;

                    //recuperation nom et email de locataire
                    $name = $facture->location->user->nom ;

                    $email = $facture->location->user->email ;

                    $details = [
                        'nom' => $name,
                        'id'=>$facture->id,
                        'montant' => $facture->montant_total+$facture->montant_total*$facture->nbt_relance
                    ];
<<<<<<< HEAD
            
               Mail::to($email )->send(new Relance($details));
              
=======

               //Mail::to($email )->send(new Relance($details));

>>>>>>> 1bc921891cdc31284c8ddb48456ab5cb9e3a96c4
                }
                if(($currentDate=$date3) && ($facture->etat_paiement=="Impaye")){
                  $facture->mois_impaye = $facture->mois_impaye+1;
                }

               }
           else{
                $facture->etat_paiement="Payé";
                $facture->nbt_relance =0;
                $facture->date_paiement = $request->date_paiement;
                $facture->mode_paiement = $request->mode_paiement;
                $facture->montant_recu= $montant_recu;
                $facture->mois_impaye = 0;

                $name = $facture->location->user->nom ;
                $email = $facture->location->user->email ;

                $details = [
                    'nom' => $name,
                    'id'=>$facture->id,
                  //  'montant' => $facture->montant_total
                ];
<<<<<<< HEAD
        
           Mail::to($email )->send(new Paiement($details));
=======

           //Mail::to($email )->send(new Paiement($details));
>>>>>>> 1bc921891cdc31284c8ddb48456ab5cb9e3a96c4
               }
               $facture->save();



    }


    public function getFactureByLocataire(Request $reqeust){
        return Facture::all()->where('location_id', '=', 123);

    }

    public function getFactureByMonth(Request $reqeust){
<<<<<<< HEAD
      $date = Carbon::today();
        
      $date->modify('first day of this month');
      $date=Carbon::parse($date)->toDateString();

   return Facture::with('location.bien.user', 'location.user')->where('mois_paiement', '=', $date)->get();
=======
       $date = Carbon::today();

        $date->modify('first day of this month');
        $date=Carbon::parse($date)->toDateString();

     return Facture::with('location.bien.user', 'location.user')->where('mois_paiement', '=', $date)->get();

>>>>>>> 1bc921891cdc31284c8ddb48456ab5cb9e3a96c4

    }


    public function getOthersInfos(Request $request){
      return Facture::with('location.bien.user', 'location.user')->find($request->id);


    }
}
