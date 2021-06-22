<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
class SocieteController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth:api', ['except' => ['AddSociete', 'register', 'logout']]);
    }
    public function  AddSociete(RegistrationFormRequest $request)
    {
        $user = new User();
        $user->patente = $request->patente;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->nom_societe = $request->nom_societe;
        $user->statut_societe = $request->statut_societe;
        $user->email = $request->email;
        $user->CIN = $request->CIN;
        $user->role = 'proprietaire';
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->RC = $request->RC;
        $user->ICE = $request->ICE;
        $user->activite = $request->activite;
        $user->archive = 0;
        $user->type = 1;
        $password = Str::random(8);
        $user->password = bcrypt($password);
        if ($request->hasFile('image'))
        {
            $file      = $request->file('image');
            $fileExtention=$file->extension();
            $filename  = $file->getClientOriginalName();
            $fileFullName=time()."-".$filename;
            $path=Str::slug($fileFullName).".".$fileExtention;
            $file->move(public_path('profile-pictures/'),$path);
            $fullpath='profile-pictures/'.$path;
            $user->image = asset($fullpath);
        }
        else
        {
            $user->image = 'http://localhost:8000/profile-pictures/1618440455-persopng.png';
        }
        $user->save();
        if ($request->hasFile('doc'))
        {
           
            $file = $request->file('doc');
            $fileExtention=$file->extension();
            $filename  = $file->getClientOriginalName();
            $fileFullName=time()."-".$filename;
            $path=Str::slug($fileFullName).".".$fileExtention;
            $file->move(public_path('documents/'),$path);
            $fullpath='documents/'.$path;
            $user->documents()->create(['nom'=>$request->nomdoc,'document'=>asset($fullpath)]);
           // $user->image = asset($fullpath);
        }
        else
        {
            $user->documents()->create(['nom'=>"file",'document'=>"empty"]);
        }
        $details=[
            'nom'=>$request->nom,
            'prenom'=>$request->prenom,
            'title'=>$request->email,
            'body'=>$password,
        ];

        Mail::to($request->email)->send(new TestMail($details));
        return "envoye";

        return response()->json([
            'message' => 'societe successfully registed',
            'user' => $user
        ], 201);
    }

    public function updateMorale(Request $request)
    {
        $user = User::find($request->id);

        $user->patente = $request->patente;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->nom_societe = $request->nom_societe;
        $user->statut_societe = $request->statut_societe;
        $user->CIN = $request->CIN;
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->RC = $request->RC;
        $user->ICE = $request->ICE;
        $user->activite = $request->activite;
        $user->save();
        return response()->json([
            'message' => 'proprietaire morale has succesfully updated ',
            'user' =>  $user
        ], 201);
    }

}
