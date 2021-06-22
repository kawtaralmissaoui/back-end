<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Support\random;
use Illuminate\Support\Facades\Storage;
use App\Mail\TestMail;
use App\Notifications\notifyproprietaire;
use App\Mail\ChangerPass;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

use Illuminate\support\Facades\DB;
use Illuminate\support\Facades\Auth;
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

    public function getUserById($id){
        $user =  User::where('role', '=', 'proprietaire')->find($id);
        return $user;
    }

    public function getUser($id){
        $user =  User::find($id);
        return $user;
    }

    public function countproprietaire()
    {
        return  User::where('role', '=', 'proprietaire')->count();
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);

        $user->civilite = $request->civilite;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->CIN = $request->CIN;
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->RC = $request->RC;
        $user->save();
        return response()->json([
            'message' => 'proprietaire has succesfully updated ',
            'user' =>  $user
        ], 201);
    }

    function bie_prop($idu)
    {
        $test = DB::table('users')
            ->join('biens', 'user_id', "=", 'biens.user_id')
            ->select('biens.*')
            ->where('biens.user_id', $idu)
            ->where('users.id', $idu)
            ->get();
        return $test;
    }

    function location($idu)
    {
        return DB::table('users')
            ->join('locations', 'user_id', "=", 'locations.user_id')
            ->select('locations.*')
            ->where('locations.user_id', $idu)
            ->where('users.id', $idu)
            ->get();
    }

    function biens($idu)
    {
        $bien = DB::select(
        "SELECT b.*,u.id FROM `locations` l,`biens` b,`users` u
        WHERE l.user_id=$idu and l.bien_id=b.id and l.user_id=u.id; ");
        return $bien;
    }

    function proprietaire($idu)
    {
        $bien = DB::select(
        "SELECT u.*,u.id FROM `locations` l,`biens` b,`users` u
        WHERE l.user_id=$idu and l.bien_id=b.id and l.user_id=u.id; ");
        return $bien;
    }

    public function mailChangerPass(Request $request)
    {
        $input = $request->email;
        //generation du mot de passe
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
        $password = substr($random, 0, 10);
        //verification de l'email
        $user = new User();
        $user = User::where('email',$input) -> first();
        if($user===null){
            return response()->json([
                'error' =>  "Le mail que vous avez saisi n'existe pas !",
            ], 401);
        }

        if($user!=null){
            $user->password = bcrypt($password);
            $user->save();
            $details = [
                'nom' => $user->nom,
                'pass' => $password
            ];

            Mail::to($user->email )->send(new ChangerPass($details));
            return response()->json([
            'message' => 'Email sent with new Password !',
            'newPASS' => $password,
            'Email' => $input,
            'user' => $user,
             ], 201);

        }

    }

    public function search($search)
    {
        $user=DB::table('users')
        ->where('nom','like','%'.$search.'%')
        ->orwhere('prenom','like','%'.$search.'%')
        ->orwhere('prenom','like','%'.$search.'%')
        ->orwhere('email','like','%'.$search.'%')
        ->orwhere('CIN','like','%'.$search.'%')
        ->orwhere('nom_societe','like','%'.$search.'%')
        ->orwhere('statut_societe','like','%'.$search.'%')
        ->orwhere('patente','like','%'.$search.'%')
        ->orwhere('RC','like','%'.$search.'%')
        ->orwhere('type','like','%'.$search.'%')
        ->get();
        return $user;
    }
    public function Affnotification($id)
    {
        $user=\App\Models\User::find($id);
     $notif = $user->unreadnotifications;
     return response()->json([

        'notif' =>  $notif
    ], 201);

        //    return $not->data['data'];
            //echo $not->data['data'];
            //var_dump($not->data);
            //$not->markAsRead();

    }
    public function chargeByProp($id){
        $charges = DB::select(
            "SELECT c.* FROM `users` u,`biens` b,`charges` c
         WHERE u.id=b.user_id and u.id='$id' and c.bien_id=b.id; ");
        return $charges;
    }






}
