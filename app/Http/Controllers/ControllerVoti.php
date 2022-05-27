<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ControllerVoti extends Controller{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function index(Request $req){
//        $candidati = DB::table("Candidati")->where("Nome","!=","Astenuti")->where("Nome","!=","Nulli")->get();
        $candidati = DB::table("Candidati")->get();
        $codici = DB::table("Codici")->get();
        return view('index', compact("candidati","codici"));
    }

    public function vota(Request $req){
        $settings = DB::table("Settings")->get();
        if(!(int)$settings->where("Nome","accetta_voti")->first()->Valore){
            return back()->with("error","Errore")->with("text","Gli scrutatori non hanno aperto le votazioni");
        }
        $codici = DB::table("Codici");
        $codice = $req->voteCode;
        if (!in_array($codice,$codici->pluck("Codice")->toArray())){
            Log::info('Incorrect Code');
            return redirect()->back()->with('error', 'Errore')->with('text', 'Codice non valido');
        }
        if($codici->where("codice",$codice)->first()->Usato){
            Log::info('Code already used');
            return redirect()->back()->with('error', 'Errore')->with('text', 'Codice già usato');
        }
        $votati = array_unique($req->votati  ?? []);
        Log::info("votati: ".json_encode($votati));
        DB::table("CodiciPartecipante")->where("codice",$req->voteCode)->update(["Usato"=>1]);
        DB::table("CodiciDelegato")->where("codice",$req->voteCode)->update(["Usato"=>1]);
        if (count($votati) > 2){
            DB::table("Candidati")->where("ID", 1)->increment("voti");
            DB::table("Candidati")->where("ID", 0)->decrement("voti");
            return redirect('/')->with('success', 'Hai votato')->with('text', 'Voto nullo registrato, grazie!');
        }
        elseif(count($votati) > 0 ){
            foreach ($votati as $voto){
                if($voto>1){
                    DB::table("Candidati")->where("ID", $voto)->increment("voti");
                }
            }
            DB::table("Candidati")->where("ID", 0)->decrement("voti");
            return redirect('/')->with('success', 'Hai votato')->with('text', 'Voto registrato, grazie!');;
        }
        return redirect('/')->with('success', 'Hai votato')->with('text', 'Astensione registrata, grazie!');
    }

    public function reset(){
        DB::table("Candidati")->update(["voti"=>0]);
        DB::table("CodiciPartecipante")->update(["Usato"=>0]);
        DB::table("CodiciDelegato")->update(["Usato"=>0]);
        DB::table("Candidati")->where("ID","0")->update(["Voti"=>DB::table("Codici")->count("Codice")]);
        return redirect('/')->with('success', 'RESET')->with('text','Reset effettuato');
    }
}
