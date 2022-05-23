@extends('layouts.app')

@section('title')
    Vota!
@endsection

@section('content')
    @php
    $debug = true;
    @endphp
    <form id="form" method="POST" action="vota">
        @csrf
        <div class="container">
            <div class="row justify-content-md-center">
                <h4 class="text-center">Voto valido: 1 o 2 preferenze</h4>
            </div>
            <div class="row justify-content-md-center">
                <h4 class="text-center">Astensione: 0 preferenze</h4>
            </div>
            <div class="row justify-content-md-center">
                <h4 class="text-center">Voto nullo: più di 2 preferenze</h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" id="voteCode" name="voteCode" value="">
                    @foreach ($candidati as $candidato)
                        @if(($candidato->ID < 2 and $debug) or $candidato->ID >= 2)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="votati[]" id="{{ $candidato->ID }}"
                                    value={{ $candidato->ID }}>
                                <h4>
                                    <label class="form-check-label" for="{{ $candidato->ID }}">
                                        {{ $candidato->Nome . ' ' . $candidato->Cognome.' '.($debug ? $candidato->voti : '') }}
                                    </label>
                                </h4>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </form>
    <button id="vota" class="btn-lg btn-primary btn-block">Vota</button>
    @if ($debug)
        <div class="row mt-5">
            <div class="col-lg-12">

                @foreach ($codici as $codice)
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">{{ $codice->Usato }}</span>
                        </div>
                        <input type="text" class="form-control" value="{{ $codice->Codice }}">
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
