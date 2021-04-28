<?php

namespace App\Http\Controllers;

use App\Http\Requests\BienRequest;
use Illuminate\Http\Request;
use App\Models\Bien;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $bien->nbr_piece = $request->nbr_piece;
        $bien->equipement = $request->equipement;
        $bien->etage = $request->etage;
        $bien->porte = $request->porte;
        $bien->user_id = $request->user_id;

        $bien->save();

        // if ($request->hasFile('images')) {
        $files = $request->file('images');
        if (!empty($files)) {
            // if (!empty($request->images)) {
            /* $data = [
                $request->allFiles(),
            ];
            return response()->json($data);*/
            print_r($request->all());

            foreach ($files as $file) {
                $image = new Image();
                $image->bien_id;

                //$file = $request->file('images');
                $fileExtention = $file->extension();
                $filename  = $file->getClientOriginalName();
                $fileFullName = time() . "-" . $filename;
                $path = Str::slug($fileFullName) . "." . $fileExtention;
                $file->move(public_path('images-bien/'), $path);
                $fullpath = 'images-bien/' . $path;
                $image->asset($fullpath);
                //$path=Storage::disk('local')->('images-bien',$image);
                $bien->images()->create(['image' => asset($fullpath), 'bien_id' => $image->bien_id]);
            } //$bien->image = asset($fullpath);
        } else {
            //$bien->images()->create(['image' => 'notworking']);
            // $bien->image = 'http://localhost:8000/images-bien/1618440455-persopng.png';
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
