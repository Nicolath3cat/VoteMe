<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;

class ControllerAmministratore extends Controller
{
    public function index()
    {
        $ruoli = DB::table('Roles')->get();
        return view('dashboards.tabs.AdminTabs', compact('ruoli'));
    }

    
    public function store(Request $request){
        abort("404");
    }

    public function store_register(Request $req){
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'ruolo' => 'required|int',
        ]);
        $email = $req->input('email');
        $password = substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        $ruolo = DB::table('Roles')->where('id', $req->input('ruolo'))->first()->Nome;
        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'role' => $req->ruolo,
            'password' => Hash::make($password),
        ]);
        Mail::to($email)->send(new RegisterMail($email,$password,$ruolo));

        return back()->with('success', 'Utente registrato correttamente')->with('text',' ');
    }
    
    public function clearData(Request $req){
        if ($req->input('Candidati')){
            DB::table("Candidati")->where("id",">","1")->delete();
        }
        if ($req->input('Opzioni')){
            DB::table("Opzioni")->where("id",">","0")->delete();
        }
        if ($req->input("Codici")){
            DB::table("Codici")->delete();
            DB::table("Candidati")->where("id","0")->update(["Voti"=>DB::table("Codici")->where("Usato","0")->count("Codice")]);
            DB::table("Opzioni")->where("id","0")->update(["Voti"=>0]);
        }
        if ($req->input('Utenti')){
            DB::table("users")->where('role','!=','0')->delete();
        }
        if ($req->input('Impostazioni')){
            DB::table("Settings")->update(["Valore"=>DB::raw('Settings.Default'),"ModificatoDa"=> Auth::user()->id]);
        }
        if ($req->input('Presenze')){
            DB::table("Presenze")->delete();
        }
        return back()->with("success","Dati richiesti eliminati")->with("text"," ");
    }

}
