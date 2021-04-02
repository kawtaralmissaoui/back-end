<?php

namespace App\Http\Controllers;
use App\Http\Requests\LocationRequest;
use Illuminate\Http\Request;
use App\Models\Location;
class LocationController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['addLocation', 'register', 'logout']]);
    }
    public function  addLocation(LocationRequest $request)
    {
        $Location = new Location ();
        $Location->date_entree = $request->date_entree;
        $Location->date_sortie = $request->date_sortie;
        $Location->montant = $request->montant;
        $Location->type = $request->type ;
        $Location->archive = $request->archive;
        $Location->user_id = $request->user_id;
        $Location->bien_id = $request->bien_id;
        $Location->save();
        return response()->json([
            'message' => 'location successfully registed',
            'location' => $Location
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
}
