<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ControllerScrutatore extends Controller
{
    public function index()
    {
        $opzioni = json_decode(DB::table('CronologiaReferendum')->orderBy('ID', 'desc')->get()->first()->Risultati ?? '{}');
        $candidati = json_decode(DB::table('CronologiaElezioni')->orderBy('ID', 'desc')->get()->first()->Risultati ?? '{}',);
        $settings = DB::table('Settings')->get();
        $totali = $settings
            ->where('Nome', 'adulti_votanti')
            ->first()->Valore;
        $votanti = DB::table('Codici')->count();
        $minimo_quorum = ceil($totali * 0.5 + 1);
        $Quorum_raggiunto = $votanti >= $minimo_quorum;
        $Inutilizzati = DB::table('Codici')->selectRaw('Gruppo, group_concat(Codice) as Codici')->where('Usato', 0)->groupBy('Gruppo')->get();
        return view("dashboards.tabs.ScrutatoriTabs", compact('settings', 'candidati', 'opzioni', 'votanti', 'minimo_quorum', 'Quorum_raggiunto', 'Inutilizzati'));
    }
    public function store(Request $request)
    {
        abort("404");
    }
    public function modalCandidati(Request $req)
    {
        $candidati = DB::table("Candidati")->where("id", ">", "1")->get();
        return view("modals.candidati", compact('candidati'));
    }
    public function modificaCandidati(Request $req)
    {
        DB::table("Settings")->where('Nome', 'titolo_elezioni')->update(['Valore' => $req->input("Domanda")]);
        DB::table("Candidati")->where("id", ">", "1")->delete();
        $nomi = $req->input("Candidati")["Nome"];
        $cognomi = $req->input("Candidati")["Cognome"];
        foreach ($nomi as $index => $Nome) {
            DB::table("Candidati")->insert(["Nome" => $Nome, "Cognome" => $cognomi[$index], "Voti" => 0]);
        }
        return redirect()->route("scrutatore");
    }
    public function toggleVoti(Request $req)
    {
        $settings = DB::table("Settings")->get();
        if (!(int)$settings->where("Nome", "accetta_voti")->first()->Valore) {
            DB::table("Settings")->where("Nome", "tipo_votazione")->update(["Valore" => $req->input('tipo_votazione'), "ModificatoDa" => Auth::user()->id]);
            DB::table("Settings")->where("Nome", "accetta_voti")->update(["Valore" => "1", "ModificatoDa" => Auth::user()->id]);
            return redirect(route('scrutatore'))->with("success", "Votazioni aperte")->with("text", "Ora si può votare!");
        } else if (DB::table("Settings")->where("Nome", "tipo_votazione")->first()->Valore == "elezioni") {
            $this->storeElezioni();
        } else if (DB::table("Settings")->where("Nome", "tipo_votazione")->first()->Valore == "referendum") {
            $this->storeReferendum();
        } else {
            return redirect(route('scrutatore'))->with("error", "non so bene cosa dovrei chiudere :|");
        }
        DB::table("Settings")->where("Nome", "accetta_voti")->update(["Valore" => "0", "ModificatoDa" => Auth::user()->id]);
        $this->resetData();
        return redirect(route('scrutatore'))->with("error", "Votazioni chiuse")->with("text", "D'ora in poi non si accettano voti");
    }

    private function resetData()
    {
        DB::table("Codici")->update(["Usato" => 0]);
        DB::table("Candidati")->update(["Voti" => 0]);
        DB::table("Opzioni")->update(["Voti" => 0]);
    }

    private function storeElezioni()
    {
        $risultati = DB::table("Candidati")->get()->toJson();
        DB::table("CronologiaElezioni")->insert(["Data" => date("Y-m-d"), "ChiusaDa" => Auth::user()->id, "Risultati" => $risultati]);
    }

    private function storeReferendum()
    {
        $risultati = DB::table("Opzioni")->get()->toJson();
        DB::table("CronologiaReferendum")->insert(["Data" => date("Y-m-d"), "ChiusaDa" => Auth::user()->id, "Risultati" => $risultati]);
    }

    public function modalOpzioni(Request $req)
    {
        $opzioni = DB::table("Opzioni")->where("id", ">", "0")->get();
        return view("modals.opzioni", compact('opzioni'));
    }

    public function modificaOpzioni(Request $req)
    {
        DB::table("Opzioni")->where("id", ">", "0")->delete();
        DB::table("Settings")->where('Nome', 'titolo_referendum')->update(['Valore' => $req->input("Domanda")]);
        $opzioni = $req->input("opzioni");
        foreach ($opzioni as $Opzione) {
            DB::table("Opzioni")->insert(["Nome" => $Opzione, "Voti" => 0]);
        }
        return redirect()->route("scrutatore");
    }
}
