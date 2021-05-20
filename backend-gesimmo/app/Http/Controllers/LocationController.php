<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User;
use App\Notifications\notifyproprietaire;
use Illuminate\support\Facades\DB;
use Illuminate\Support\Facades\Notification;

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
        $Location->montant = $request->montant;
        $Location->duree = $request->duree;
        $Location->type = $request->type;
        $Location->archive = 0;
        $Location->user_id = $request->user_id;
        $Location->bien_id = $request->bien_id;

        if($Location->save())
        {
            //$user=user::all();
            $user=user::find($request->user_id);
            Notification::send($user , new notifyproprietaire($Location));
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
           
        ], 201);
    }
    public function getLocationActif()
    {
        return  Location::all()->where('archive', '=', '0');
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
        $Location =  Location::find($id);
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
}
