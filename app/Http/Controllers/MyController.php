<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class MyController extends Controller{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function index(Request $req){
//        $candidati = DB::table("Candidati")->where("Nome","!=","Astenuti")->where("Nome","!=","Nulli")->get();
        $candidati = DB::table("Candidati")->get();
        $codici = DB::table("CodiciPartecipante")->get();
        return view('index', compact("candidati","codici"));
    }

    private function vota($votati, $codice){
        $votati = array_unique($votati  ?? []);
        Log::info("votati: ".json_encode($votati));
        DB::table("CodiciPartecipante")->where("codice",$codice)->update(["Usato"=>1]);
        DB::table("CodiciDelegato")->where("codice",$codice)->update(["Usato"=>1]);
        if (count($votati) >0 and count($votati) != 2){
            DB::table("Candidati")->where("ID", 1)->increment("voti");
            DB::table("Candidati")->where("ID", 0)->decrement("voti");
            return redirect('/')->with('success', 'Voto nullo registrato, grazie!');
        }
        elseif(count($votati) == 2){
            foreach ($votati as $voto){
                if($voto>1){
                    DB::table("Candidati")->where("ID", $voto)->increment("voti");
                }
            }
            DB::table("Candidati")->where("ID", 0)->decrement("voti");
            return redirect('/')->with('success', 'Voto registrato, grazie!');
        }
        return redirect('/')->with('success', 'Astensione registrata, grazie!');
    }

    public function valida(Request $req){
        Log::info(DB::table("Codici")->where("Usato",0)->pluck("Codice")->toArray());
        Log::info("Code: ".$req->voteCode);
        $codici = DB::table("Codici");
        $codice = $req->voteCode;
        if (!in_array($codice,$codici->pluck("Codice")->toArray())){
            Log::info('Incorrect Code');
            return redirect('/')->with('error', 'Codice non valido');
        }

        if($codici->where("codice",$codice)->first()->Usato){
            Log::info('Code already used');
            return redirect('/')->with('error', 'Codice già usato');
        }
        return $this->vota($req->votati,$codice);

    }

    public function reset(){
        DB::table("Candidati")->update(["voti"=>0]);
        DB::table("CodiciPartecipante")->update(["Usato"=>0]);
        DB::table("CodiciDelegato")->update(["Usato"=>0]);
        DB::table("Candidati")->where("ID","0")->update(["Voti"=>DB::table("Codici")->count("Codice")]);
        return redirect('/')->with('success', 'Reset effettuato');
    }
}
