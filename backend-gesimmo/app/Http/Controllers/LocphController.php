<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
class LocphController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['addLocP', 'register', 'logout']]);
    }
    public function  addLocP(RegistrationFormRequest $request)
    {
        $user = new User();
        $user->civilite = $request->civilite;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->CIN = $request->CIN;
        $user->role = 'locataire';
        $user->adresse = $request->adresse;
        $user->archive = 0;
        $user->type = 0;
        $user->password = bcrypt($request->password);
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
        return response()->json([
            'message' => 'locataire successfully registed',
            'user' => $user
        ], 201);
    }

    public function getLocPhyActif()
    {
        return  User::all()->where('role', '=', 'locataire')->where('archive', '=', '0');
    }
    public function getLocPhyArchive()
    {
        return  User::all()->where('role', '=', 'locataire')->where('archive', '=', '1');
    }
    public function counlocataire()
    {
        return  User::where('role', '=', 'locataire')->count();
    }
    public function getlocataireById($id){
        $user =  User::where('role', '=', 'locataire')->find($id);
        return $user;
    }

    public function archiverUser($id){
        $user =  User::find($id);
        if($user)
        {
            $user->archive=1;
            $user->save();
        }
        return response()->json([
            'message' => 'user archive',
        ], 201);
    }
}
