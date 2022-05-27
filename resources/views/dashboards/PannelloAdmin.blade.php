@extends('layouts.app')

@section('title')
    Control Panel
@endsection

@section('content')
    {{-- voting form multiple choice --}}
    <form id="form" method="POST" action="generaCodici">
        @csrf
        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <h4 class="text-center">Inserisci mail partecipante e numero di deleghe assegnate</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <input type="email" id="email" name="email" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                </div>
            </div>
        </div>
    </form>
    <button id="vota" class="btn-lg btn-primary btn-block">Vota</button>
@endsection


