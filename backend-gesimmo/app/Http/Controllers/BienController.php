<?php

namespace App\Http\Controllers;

use App\Http\Requests\BienRequest;
use Illuminate\Http\Request;
use App\Models\Bien;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\support\Facades\DB;

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
        $bien->statut = 0;
        $bien->loyer_mensuel = $request->loyer_mensuel;
        $bien->syndic = $request->syndic;
        $bien->code_postal = $request->code_postal;
        $bien->taxe_habitation = $request->taxe_habitation;
        $bien->archive = 0;
        $bien->type = $request->type;;
        $bien->nbr_piece = $request->nbr_piece;
        $bien->equipement = $request->equipement;
        $bien->etage = $request->etage;
        $bien->porte = $request->porte;
        $bien->user_id = $request->user_id;
        $bien->save();
        print_r($request->all());

        $files = $request->file('images');
        if (!empty($files)) {
            foreach ($files as $file) {
                $fileExtention = $file->extension();
                $filename  = $file->getClientOriginalName();
                $fileFullName = time() . "-" . $filename;
                $path = Str::slug($fileFullName) . "." . $fileExtention;
                $file->move(public_path('images-bien/'), $path);
                $fullpath = 'images-bien/' . $path;
                $bien->images()->create(['image' => asset($fullpath)]);
            }
        } else {
            return response()->json([
                'message' => 'error',
            ]);
        }

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

    public function getbienById($id)
    {
        $bien =  Bien::find($id);
        return $bien;
    }

    public function archiverBien($id)
    {
        $bien =  Bien::find($id);
        if ($bien) {
            $bien->archive = 1;
            $bien->save();
        }
        return response()->json([
            'message' => 'bien archive',
        ], 201);
    }

    public function updatebien(Request $request)
    {
        $bien = Bien::find($request->id);

        //$bien->identifiant = $request->identifiant;
        $bien->adresse = $request->adresse;
        $bien->surface = $request->surface;
        $bien->loyer_mensuel = $request->loyer_mensuel;
        $bien->syndic = $request->syndic;
        $bien->taxe_habitation = $request->taxe_habitation;
        $bien->nbr_piece = $request->nbr_piece;
        $bien->equipement = $request->equipement;
        $bien->etage = $request->etage;
        $bien->porte = $request->porte;
        //$bien->user_id = $request->user_id;
        $bien->code_postal = $request->code_postal;
        $bien->save();
        return response()->json([
            'message' => 'BIEN has succesfully updated ',
            'user' =>  $bien
        ], 201);
    }
}
