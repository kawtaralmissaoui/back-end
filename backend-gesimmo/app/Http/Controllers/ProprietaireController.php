<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
class ProprietaireController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['AddProprietaire', 'register', 'logout']]);
    }

    public function  AddProprietaire(RegistrationFormRequest $request)
    {

        $user = new User();
        $user->civilite = $request->civilite;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->CIN = $request->CIN;
        $user->role = 'proprietaire';
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->archive = 0;
        if ($request->hasFile('image'))
        {
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            //$extension = $file->getClientOriginalExtension();
            //$file->move(public_path('img'), $filename);
            $path=Storage::disk('local')->put('images',$file);
            $user->image = $path;
        }
        else
        {
            $user->image = 'dfgdf';
        }
        //$user->documents()->create(['nom'=>'kkkk','document'=>'fac.pdf']);
        $user->password = bcrypt($request->password);
        $user->save();
        if ($request->hasFile('doc'))
        {
            $file= $request->file('doc');
            $path=Storage::disk('local')->put('documents',$file);
            $user->documents()->create(['nom'=>$request->nom,'document'=>$path]);
        }
        else
        {
            return 'select fichier pdf';
        }

        //$user->documents()->create(['nom'=>$request->nom,'document'=>$request->document]);





        return response()->json([
            'message' => 'proprietaire successfully registed',
            'user' => $user
        ], 201);
    }
    public function getProPhyActif()
    {
        return  User::all()->where('role', '=', 'proprietaire')->where('archive', '=', '0');
    }
    public function getProPhyArchive()
    {
        return  User::all()->where('role', '=', 'proprietaire')->where('archive', '=', '1');
    }


    public function countproprietaire()
    {
        return  User::where('role', '=', 'proprietaire')->count();
    }
}
