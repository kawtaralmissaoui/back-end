<?php

namespace App\Http\Controllers;
use App\Http\Requests\FactureRequest;
use Illuminate\Http\Request;
use App\Models\Facture;
use App\Models\Mode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Relance;
use App\Mail\Paiement;
use Illuminate\support\Facades\DB;

class PaiementController extends Controller
{
    public function __construct()
    {
     //   $this->middleware('auth:api', ['except' => ['addPaiement', 'register', 'logout']]);
    }
    
/* notification : Nous accusons récéption du paiement de votre loyer pour le mois  --date pour une somme  du --montant */ 
    public function updateFacture(Request $request){
        $facture = Facture::with('location.user')->find($request->id);
        $montant_recu = $facture->montant_recu;


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
                //changer vers  impayé
                if($currentDate>=$date1) {$facture->etat_paiement="Impayé";  }

                if(($currentDate->toDateString())==($date1->toDateString()) || ($currentDate->toDateString())==($date2->toDateString()) || ($currentDate->toDateString())==($date3->toDateString()))
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
            
               Mail::to($email )->send(new Relance($details));
              
                }
                if($currentDate==$date3) {$facture->mois_impaye = $facture->mois_impaye+1;}

               }
           else{
                $facture->etat_paiement="Payé";
                $facture->nbt_relance =0;
               // $facture->date_paiement = $request->date_paiement;
               // $facture->mode_paiement = $request->mode_paiement;
               // $facture->montant_recu= $montant_recu;
                $facture->mois_impaye = 0;

                $name = $facture->location->user->nom ;
                $email = $facture->location->user->email ;

                $details = [
                    'nom' => $name,
                    'id'=>$facture->id,
                  //  'montant' => $facture->montant_total
                ];
        
           Mail::to($email )->send(new Paiement($details));
               }
               $facture->save();



    }


    public function getFactureByLocataire(Request $reqeust){
        return Facture::all()->where('location_id', '=', 123);

    }

    public function impaye(Request $reqeust){
      $currentDate = Carbon::now();
                
     
               

       $fac = $this->getFactureByMonth($reqeust);
       foreach ($fac as $data) {
        $date1 = new Carbon($data->mois_paiement);          
        $date1->addDays(5); 
        
         if($data->etat_paiement=="En attente")
         {
           

          if($currentDate>=$date1) {$data->etat_paiement="Impayé"; $data->save();  }
         }
       }
       
       return $fac;
       

  
  


  }

    public function getFactureByMonth(Request $reqeust){
      $date = Carbon::today();
        
      $date->modify('first day of this month');
      $date=Carbon::parse($date)->toDateString();

   return Facture::with('location.bien.user', 'location.user')->where('mois_paiement', '=', $date)->get();

    }


    public function getOthersInfos(Request $request){
      return Facture::with('location.bien.user', 'location.user')->find($request->id);


    }

    public function Charts(Request $request){
      $paiement = DB::select(
        "SELECT mois_paiement,SUM(montant_recu) as montant FROM
        `factures` WHERE YEAR(NOW())=YEAR(mois_paiement) 
        GROUP BY mois_paiement ;");

    $charge = DB::select(
  "SELECT date_paiement,SUM(montant_total) as montant FROM
  `charges`  WHERE YEAR(NOW())=YEAR(date_paiement) 
   GROUP BY MONTH(date_paiement) ;");
        return response()->json([
          'Paiement' => $paiement,
          'Charge ' => $charge
      ], 201);
    }
}
