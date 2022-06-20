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
    Accedi al sito {!! env('APP_URL', 'http://vota.cngei-vicenza.it') !!}/login
    ed inserisci le seguenti credenziali:<br>
    email: <input value="{{ $email }}"><br>
    password: <input value="{{ $password }}"><br>
@endsection


