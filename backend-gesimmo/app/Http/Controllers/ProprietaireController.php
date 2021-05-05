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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Facades\DB;

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

        $user=\App\Models\User::find(3);
        $user->notify(new notifyproprietaire());

        $details=[
            'nom'=>$request->nom,
            'prenom'=>$request->prenom,
            'title'=>$request->email,
            'body'=>$password,
        ];

        Mail::to($request->email)->send(new TestMail($details));
        return "envoye";

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



       /* if(!empty($request->documents))
        {
            foreach(json_decode($request->documents) as $document)
            {
                $path2=Storage::disk('local')->put('/documents',$document->doc);
                $user->documents()->create(['nom'=>$document->nom,'document'=>$path2]);
            }
        }
        else
        {
            $user->documents()->create(['nom'=>'scan','document'=>'doc.jpg']);
        }*/





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



}
