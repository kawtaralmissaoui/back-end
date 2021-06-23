<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\support\Facades\DB;
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

    function proprietaire($idu)
    {
        $bien = DB::select(
        "SELECT DISTINCT (u.id),u.*FROM `locations` l,`biens` b,`users` u
        WHERE l.user_id=$idu and l.bien_id=b.id and b.user_id=u.id; ");
        return $bien;
    }

    function paloc($idu)
    {
        $paiement = DB::select(
        "SELECT DISTINCT(f.id), f.*,l.identifiant FROM `users` u,`locations` l,`factures` f
        WHERE l.user_id=$idu and l.id=f.location_id ; ");
        return $paiement;
    }
}
