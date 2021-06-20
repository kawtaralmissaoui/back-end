<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Mode;
use Illuminate\Http\Request;
use App\Http\Controllers\PaiementController;

class ModeController extends Controller
{
    public function addMode(Request $request)
    {


        $Mode = new Mode ();
        $Mode->montant = $request->montant ;
        $Mode->mode_paiement = $request->mode_paiement ;
        $Mode->numero_operation = $request->numero_operation ;
        $Mode->banque = $request->banque;
        $Mode->date = $request->date;
        $Mode->execution =0;
        if($request->mode_paiement=="cheque"){ $Mode->etat = "En attente d'encaissement";}
        if($request->mode_paiement=="virement"){ $Mode->etat = "En attente de virement";}
        if($request->mode_paiement=="espece"){ $Mode->etat = "reglé";}
        if($request->mode_paiement=="caution"){ $Mode->etat = "appliqué";}
        $Mode->description = $request->description;
        $Mode->facture_id = $request->facture_id;
        //$Mode->save();
        /* if ($this->loginAfterSignUp) {
            return $this->login($request);
        }*/
        $facture = Facture::with('location')->find($Mode->facture_id);
        if($Mode->mode_paiement=="espece")
            { 
                $Mode->execution=1;
                $facture->montant_recu = $facture->montant_recu + $Mode->montant;
                //$facture->save();
            }
        if($Mode->mode_paiement=="caution")
            { 
               //$Mode->montant = $facture->montant_total;
              // $Mode->save();
               //echo $Mode->montant;
            //$Mode->execution=1;
               // $facture->montant_recu = $facture->montant_recu + $Mode->montant;
               // $facture->save();
                if ($facture->location->caution==1) {
                    if ($facture->location->nbr_mois_caution > 0) {
                         $Mode->montant = $facture->montant_total;
                         $Mode->execution=1;
                         
                        $facture->montant_recu = $facture->montant_recu + $Mode->montant;
                        // $facture->save();
                         $facture->location->nbr_mois_caution = $facture->location->nbr_mois_caution -1 ;
                        // $facture->location->save();
                    }
                    
                  if($facture->location->nbr_mois_caution == 0 )      {$facture->location->caution = 0;}
                        
                       // $facture->location->save();

                    

                }
            }
        $Mode->save();
        $facture->save();
        $facture->location->save();
            //test
        $t = new FactureController;
// Use other controller's method in this controller's method
        $request->id = $Mode->facture_id;
        $t->updateFacture($request);

        return response()->json([
            'message' => 'Mode  successfully registed',
            'Mode ' => $Mode
        ], 201);
    }

    public function RemiseMode(Request $request)
    {
        $id = $request->id;
        return Mode::with('facture')->find($id);
        //echo $modes->facture->etat_paiement; 
        // echo $modes->etat; 


        

    }
    public function updateMode(Request $request)
    {
        $id = $request->id;
        $modes = Mode::with('facture')->find($id);

        if($modes->mode_paiement=="cheque"){ $modes->etat = "Encaissé";}
        if($modes->mode_paiement=="virement"){ $modes->etat = "Executé";}

        $modes->numero_remise=$request->numero_remise;
        $modes->date_remise=$request->date_remise;
        $modes->execution=1;
        
        $modes->facture->montant_recu = $modes->facture->montant_recu + $modes->montant;
        $modes->facture->date_paiement = $modes->date_remise;
        $modes->save();
        $modes->facture->save();;
        //$FacController = new FactureController();
       // $FacController->updateFacture($request);
        

        //echo $modes->facture->etat_paiement; 
        // echo $modes->etat; 
               //test
        $t = new PaiementController;
// Use other controller's method in this controller's method
        $request->id = $modes->facture_id;
        $t->updateFacture($request);
        

        

    }
}

