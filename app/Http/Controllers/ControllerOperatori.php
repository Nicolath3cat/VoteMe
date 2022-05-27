<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\CodeMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ControllerOperatori extends Controller
{
    public function index_accoglienza(){
        return view("dashboards.PannelloAccoglienza");
    }

    public function index_scrutatore(){
        $candidati = DB::table('Candidati')->get();
        return view("dashboards.PannelloScrutatore", compact('candidati'));
    }

    public function generaCodici(Request $req){
        //generate random 10 char code
        $codiciDelega = array();
        $codiceProprio = substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        for($i=0;$i<$req->input("deleghe");$i++){
            //append codice random to array
            $Codice= substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
            array_push($codiciDelega,$Codice);
            DB::table("CodiciDelegato")->insert(["Codice"=>$Codice,"Usato"=>0]);
        }
        DB::table("CodiciPartecipante")->insert(["codice"=>$codiceProprio,"Usato"=>0]);

        Mail::to($req->input('email'))->send(new CodeMail($codiceProprio,$codiciDelega));
    }

    public function toggleVoti(){
        $settings = DB::table("Settings")->get();
        if(!(int)$settings->where("Nome","accetta_voti")->first()->Valore){
            DB::table("Settings")->where("Nome","accetta_voti")->update(["Valore"=>"1","ModificatoDa"=>Auth::user()->id]);
            return back()->with("success","Votazioni aperte")->with("text","Ora si può votare!");
        }
        else{
            DB::table("Settings")->where("Nome","accetta_voti")->update(["Valore"=>"0","ModificatoDa"=>Auth::user()->id]);
            return back()->with("error","Votazioni chiuse")->with("text","D'ora in poi non si accettano voti");
        }
    }

}
