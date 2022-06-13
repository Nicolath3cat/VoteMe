<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeMail;
use Illuminate\Support\Carbon;

class ControllerSegretario extends Controller
{
    public function index()
    {
        $Presenze = DB::table('Presenze')
        ->whereNull('Uscita')
        ->get();
        return view("dashboards.tabs.SegretarioTabs", compact('Presenze'));
    }
    public function store(Request $request)
    {
        abort("404");
    }

    private function SegnaPresenza(Request $req)
    {
        $now = Carbon::now();
        $id = DB::table("Presenze")->insertGetId(['Nome' => $req->input('Nome'), 'Cognome' => $req->input('Cognome'), 'Email' => $req->input('Email'), 'Entrata' => $now, 'Uscita' => null]);
        return $id;
    }
    public function entrata(Request $req)
    {
        $req->validate([
            'Nome' => 'required|string|max:255',
            'Cognome' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255',
            'Deleghe' => 'required|int|min:0|max:2',
        ]);
        //generate random 10 char code
        $id = $this->SegnaPresenza($req);
        $Numero_di_Deleghe = $req->input("Deleghe");
        $codiciDelega = array();
        $codiceProprio = substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        for ($i = 0; $i < $Numero_di_Deleghe; $i++) {
            //append codice random to array
            $Codice = substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
            array_push($codiciDelega, $Codice);
            DB::table("Codici")->insert(["Codice" => $Codice, "Usato" => 0, "Tipo" => "Delegato", 'Gruppo' => $id]);
        }
        DB::table("Codici")->insert(["Codice" => $codiceProprio, "Usato" => 0, "Tipo" => "Proprio", "Gruppo" => $id]);
        DB::table("Candidati")->where("id", "0")->update(["Voti" => DB::table("Codici")->where("Usato", "0")->count("Codice")]);
        Mail::to($req->input('Email'))->send(new CodeMail($codiceProprio, $codiciDelega));
        return back()->with('success', 'Codici inviati correttamente');
    }

    public function uscita(Request $req)
    {
        $req->validate([
            'id' => 'required|int|min:0',
        ]);
        $id = $req->input("id");
        $now = Carbon::now();
        DB::table("Presenze")->where("id", $id)->update(["Uscita" => $now]);
        DB::table("Codici")->where("Gruppo", $id)->delete();
        return back()->with('success', 'Uscita registrata correttamente');
    }
}
