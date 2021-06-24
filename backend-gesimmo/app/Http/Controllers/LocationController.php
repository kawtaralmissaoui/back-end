<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User;
use App\Notifications\notifyproprietaire;
use Illuminate\support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use App\Models\Bien;
use App\Models\Facture;




class LocationController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['addLocation', 'register', 'logout']]);
    }
    public function  addLocation(LocationRequest $request)
    {
        $Location = new Location();
        $Location->identifiant = $request->identifiant;
        $Location->date_entree = $request->date_entree;
        $Location->date_sortie = $request->date_sortie;
        //calculer la durée
        $to = new Carbon($Location->date_entree);
        $from =  new Carbon ($Location->date_sortie);
        //$diff_in_months = $to->diffInMonths($from);
        $Location->duree = $request->duree;
        $Location->type = $request->type;
        $Location->archive = 0;
        //ajout caution :
        if($request->caution == 1 ) {$Location->caution = 1 ;}
        else {$Location->caution = 0 ;}
        
        $Location->nbr_mois_caution = $request->nbr_mois_caution;

        $Location->user_id = $request->user_id;
        $Location->bien_id = $request->bien_id;

        //calculer le montant 
        $bien = Bien::find( $request->bien_id);
        $Location->montant = $bien->loyer_mensuel+$bien->syndic;

        if($Location->save())
        {
            //$user=user::all();
            $user=user::find($request->user_id);
            Notification::send($user , new notifyproprietaire($Location));
            $bien = Bien::find($Location->bien_id);

            // le 1 de chaque moi
            $to->modify( 'first day of this month' );

            for($i=0; $i<$Location->duree; $i++)
{
    $Facture = new Facture ();


       
        $Facture->mois_paiement = $to;
       // $Facture->type = 'paiement' ;

       // $Facture->loyer_mensuel = $bien->loyer_mensuel;
        //$Facture->syndic = $request->syndic;
         $Facture->etat_paiement = "En attente";
     //   $montantTotale = $bien->loyer_mensuel + $bien->syndic;
        $Facture->montant_total = $Location->montant;
        $Facture->mois_impaye = 0;
        $Facture->archive = 0;
        $Facture->nbt_relance = 0;
        $Facture->nbr_relance_total=0;
        $Facture->montant_recu = 0;

       
       

           $Facture->location_id= $Location->id;

           $currentDate = Carbon::now();
         

       //f($Facture->montant_recu<$Facture->montant_total)
            //  { echo "yes";
                $date = new Carbon($Facture->mois_paiement);
                $date->addDays(5);
                if($currentDate>$date){ $Facture->etat_paiement="Impayé"; }
                $Facture->save();
                $to->modify( 'first day of next month' );
    
    
            }
        };
     //$locataire=Location::with('user')->find($Location->id);
        $Bien = DB::table('locations')
        ->join('biens', 'bien_id', "=", 'biens.id')
        ->select('biens.adresse','locations.date_entree',
        'locations.date_sortie','locations.duree','biens.etage','biens.porte','biens.equipement'
        ,'biens.type','biens.loyer_mensuel','biens.syndic')
        ->where('locations.id', $Location->id)
        ->get();
        $Loc = DB::table('locations')
        ->join('users', 'user_id', "=", 'users.id')
        ->select('users.nom','locations.type','users.prenom','users.adresse','users.civilite','users.CIN')
        ->where('locations.id', $Location->id)
        ->get();
        $Prop = DB::select(
            "SELECT p.nom, p.prenom,p.CIN,p.adresse,p.civilite FROM `locations` l , `biens` b, `users` p WHERE l.id=$Location->id and l.bien_id=b.id and b.user_id=p.id ;");
        DB::table('biens')
            ->join('locations', 'bien_id', "=", 'locations.bien_id')
            //->select('biens.*')
            ->where('biens.id', $Location->bien_id)
            ->where('locations.bien_id', $Location->bien_id)
            ->update(['statut' => 'occupé']);
        return response()->json([
            'message' => 'location successfully registed',
            'location' => $Location,
            'Bien' => $Bien,
            'Loc' => $Loc,
            'Prop' => $Prop,
            'Facture' => $Facture
           
        ], 201);
    }


    public function getLocationActif()
    {
        return  Location::orderBy('created_at', 'desc')->where('archive', '=', '0')->get();
    }
    public function getLocationArchive()
    {
        return  Location::all()->where('archive', '=', '1');
    }
    public function countlocation()
    {
        return  Location::all()->count();
    }
    public function getlocationById($id)
    {
        $Location =  Location::with('user','bien')->find($id);
        return $Location;
    }
    public function archiverLocation($id)
    {
        $Location =  Location::find($id);
        if ($Location) {
            $Location->archive = 1;
            $Location->save();
        }
        return response()->json([
            'message' => 'bien archive',
        ], 201);
    }

    public function updatelocation(Request $request)
    {
        $Location = Location::find($request->id);

        $Location->identifiant = $request->identifiant;
        $Location->date_entree = $request->date_entree;
        $Location->date_sortie = $request->date_sortie;
        $Location->montant = $request->montant;
        $Location->duree = $request->duree;
        $Location->type = $request->type;
        $Location->user_id = $request->user_id;
        $Location->bien_id = $request->bien_id;
        $Location->save();

        return response()->json([
            'message' => 'proprietaire has succesfully updated ',
            'user' =>  $Location
        ], 201);
    }

    function show()
    {
        $test = DB::table('biens')
            ->join('locations', 'bien_id', "=", 'locations.bien_id')
            ->select('biens.statut')
            ->where('biens.id', 5)
            ->where('locations.bien_id', 5)
            //->where('biens.id','locations.bien_id')
            ->get();

        return $test;
    }
    public function searchLocation($search)
    {
        $location=DB::table('locations')
        ->where('type','like','%'.$search.'%')
        ->orwhere('date_entree','like','%'.$search.'%')
        ->orwhere('date_sortie','like','%'.$search.'%')
        ->orwhere('montant','like','%'.$search.'%')
        ->get();
        return $location;
    }
}
