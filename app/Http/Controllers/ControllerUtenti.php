<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isNull;

class ControllerUtenti extends Controller
{

    public function index(Request $req)
    {
        $tipo = DB::table("Settings")->where("Nome", "tipo_votazione")->first()->Valore;
        if ($tipo == "elezioni") {
            $candidati = DB::table("Candidati")->get();
            $codici = DB::table("Codici")->get();
            return view('index_elezioni', compact("candidati", "codici"));
        } elseif ($tipo == "referendum") {
            $opzioni = DB::table("Opzioni")->get();
            $codici = DB::table("Codici")->get();
            return view('index_referendum', compact("opzioni", "codici"));
        }
        return abort('500');
    }

    public function logout()
    {
        Auth::logout();
        return back();
    }


    public function Elezioni(Request $req)
    {
        //controllo se la votazione è aperta
        if (!(int)DB::table("Settings")->where("Nome", "accetta_voti")->first()->Valore) {
            return back()->with("error", "Errore")->with("text", "Gli scrutatori non hanno aperto le votazioni");
        }
        //controllo se il tipo di votazione non è referendum
        if (DB::table("Settings")->where("Nome", "tipo_votazione")->first()->Valore == 'referendum') {
            abort("400");
            return back()->with("error", "Errore")->with("text", "Errore nella votazione, attendi e riprova!");;
        }

        $codice = $req->voteCode;
        //controllo se il codice è valido
        if (!in_array($codice, DB::table("Codici")->pluck("Codice")->toArray())) {
            Log::info('Incorrect Code');
            return back()->with('error', 'Errore')->with('text', 'Codice non valido');
        }
        //controllo se il codice è già stato utilizzato
        if (DB::table("Codici")->where("codice", $codice)->first()->Usato) {
            Log::info("$codice Code already used");
            return back()->with('error', 'Errore')->with('text', 'Codice già usato');
        }

        $votati = array_unique($req->votati ?? []);
        Log::info("votati: " . json_encode($votati));

        //se i votati sono più di 2 allora è nullo
        if (count($votati) > 2) {
            DB::table("Candidati")->where("id", 1)->increment("voti");
            $message = 'Voto nullo registrato, grazie!';
        }
        //se i votati sono 1 o 2 allora è valido
        elseif (count($votati) > 0) {
            foreach ($votati as $voto) {
                if ($voto > 1) {
                    DB::table("Candidati")->where("id", $voto)->increment("voti");
                }
            }
            $message = 'Voto registrato, grazie!';
        }
        //altrimenti è astensione
        else{
            DB::table("Candidati")->where("id", 0)->increment("voti");
            $message = 'Astensione registrata, grazie!';
        }
        DB::table("Codici")->where("codice", $codice)->update(["Usato" => 1]);
        return back()->with('success', 'Hai votato')->with('text', $message);
    }


    public function Referendum(Request $req)
    {
        //controllo se la votazione sia aperta
        if (!(int)DB::table("Settings")->where("Nome", "accetta_voti")->first()->Valore) {
            return back()->with("error", "Errore")->with("text", "Gli scrutatori non hanno aperto le votazioni");
        }
        //controllo se il tipo di votazione non sia elezioni
        if (DB::table("Settings")->where("Nome", "tipo_votazione")->first()->Valore == 'elezioni') {
            abort("400");
            return back()->with("error", "Errore")->with("text", "Errore nella votazione, attendi e riprova!");;
        }

        $codice = $req->voteCode;
        //Controllo se il codice è valido
        if (!in_array($codice, DB::table("Codici")->pluck("Codice")->toArray())) {
            Log::info('Incorrect Code');
            return back()->with('error', 'Errore')->with('text', 'Codice non valido');
        }
        //Controllo se il codice è già stato usato
        if (DB::table("Codici")->where("codice", $codice)->first()->Usato) {
            Log::info("$codice Code already used");
            return back()->with('error', 'Errore')->with('text', 'Codice già usato');
        }

        $votato = $req->input("votato");
        //controllo se il voto è valido
        if (is_null($votato)) {
            return back()->with("error", "Scelta nulla!")->with("text", "Se vuoi astenerti scegli l'opzione dedicata");
        }
        //sequenza di voto
        DB::table("Opzioni")->where("id", $votato)->increment("voti");
        DB::table("Codici")->where("codice", $codice)->update(["Usato" => 1]);
        return redirect('/')->with('success', 'Hai votato')->with('text', 'Voto registrato, grazie!');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function store_login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if (!Auth::attempt($req->only('email', 'password'))) {
            return back()->with(['toast' => 'Email o password non corretti']);
        }

        return back();
    }
}
