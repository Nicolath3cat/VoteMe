@extends('layouts.app')

@section('title')
    Vota!
@endsection

@section('content')
    @php
    $accetta_voti = DB::table('Settings')
        ->where('Nome', 'accetta_voti')
        ->first()->Valore;

    @endphp
    <div class="container ">
        <div class="row justify-content-md-center">
            @if ($accetta_voti)
                <form id="form" method="POST" action="{{ route('vota_elezioni') }}">
                    @csrf
                    <div class="row justify-content-md-center">
                        <h1 class="col text-center">
                            {{ DB::table('Settings')->where('Nome', 'titolo_elezioni')->first()->Valore}}
                            </h4>
                    </div>
                    <div class="row justify-content-md-center">
                        <h4 class="col text-center">Voto valido: 1 o 2 preferenze</h4>
                    </div>
                    <div class="row justify-content-md-center">
                        <h4 class="col text-center">Astensione: 0 preferenze</h4>
                    </div>
                    <div class="row justify-content-md-center">
                        <h4 class="col text-center">Voto nullo: più di 2 preferenze</h4>
                    </div>
                    <div class="row">
                        <div class="col-sm mt-5 mb-5">
                            <input type="hidden" id="voteCode" name="voteCode" value="">
                            @foreach ($candidati as $candidato)
                                @if ($candidato->id >= 2 or $debug)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="votati[]"
                                            id="{{ $candidato->id }}" value={{ $candidato->id }}>
                                        <h4>
                                            <label class="form-check-label" for="{{ $candidato->id }}">
                                                {{ $candidato->Nome . ' ' . $candidato->Cognome . ' ' . ($debug ? $candidato->voti : '') }}
                                            </label>
                                        </h4>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <button type="button" id="triggerSwalText" data-title="Un ultimo step..."
                            data-text="Inserisci codice di voto" data-ConfirmBtn="Vota!" data-CancelBtn="Annulla"
                            class="col-sm-12 btn-lg btn-primary btn-block">Prosegui</button>
                    </div>
                </form>
            @else
                <div class="row justify-content-md-center">
                    <h1 class="col text-center">Nulla da fare qui...</h3>
                </div>
                <div class="row justify-content-md-center">
                    <h4 class="col text-center">Gli scrutatori non hanno aperto le votazioni</h4>
                </div>
            @endif
        </div>
    </div>
@endsection
