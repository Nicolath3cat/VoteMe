<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\DB;

class ControllerUtenti extends Controller
{
    public function index_register(){
        return view('auth.register');
    }

    public function index_login(){
        return view('auth.login');
    }

    public function store_register(Request $req){
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'ruolo' => 'required|int',
        ]);
        $email = $req->input('email');
        $password = substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        $ruolo = DB::table('roles')->where('id', $req->input('ruolo'))->first()->name;
        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'role' => $req->ruolo,
            'password' => Hash::make($password),
        ]);
        Mail::to($email)->send(new RegisterMail($email,$password,$ruolo));

        return redirect()->route('vota');
    }

    public function store_login(Request $req){
        $req->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if(!Auth::attempt($req->only('email', 'password'))){
            return redirect()->back()->with(['toast' => 'Email o password non corretti']);
        }

        return back();
    }

    public function logout(){
        Auth::logout();
        return back();
    }

}
