{{-- simple mail laravel  --}}
@extends('layouts.mail')


@section('title')
<style type="text/css">
.im {
color: #000000 !important;
}
</style>
@endsection
@section('body')
    Ciao!<br>
    Un nuovo utente è stato creato per il tuo ruolo: {{ $ruolo }}
    <br>
    Per accedere al sito <a href="{{ env("APP_URL","vota.cngei-vicenza.it:1915) }}/login">clicca qui</a>
    ed inserisci le seguenti credenziali:<br>
    email: <input value="{{ $email }}"><br>
    password: <input value="{{ $password }}"><br>
@endsection


