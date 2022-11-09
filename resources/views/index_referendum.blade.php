@extends('layouts.app')

@section('title')
    Vota!
@endsection

@section('content')
    @php
    $accetta_voti = DB::table('Settings')->where('Nome', 'accetta_voti')->first()->Valore;
    @endphp
    <div class="container ">
        <div class="row justify-content-md-center" >
            @if($accetta_voti)
                <form id="form" method="POST" action="{{ route('vota_referendum') }}">
                    @csrf
                    <div class="row justify-content-md-center">
                        <h1 class="col text-center">{{ DB::table("Settings")->where("Nome","titolo_referendum")->first()->Valore}}</h4>
                    </div>
                    <div class="row justify-content-md-center">
                        <h4 class="col text-center">Voto valido: 1 preferenza</h4>
                    </div>
                    <div class="row justify-content-md-center">
                        <h4 class="col text-center">Astensione: 0 preferenze</h4>
                    </div>
                    <div class="row">
                        <div class="col-sm mt-5 mb-5">
                            <input type="hidden" id="voteCode" name="voteCode" value="">
                            @foreach ($opzioni as $opzione)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="votato"
                                            id="{{ $opzione->id }}" value={{ $opzione->id }}>
                                        <h4>
                                            <label class="form-check-label" for="{{ $opzione->id }}">
                                                {{ $opzione->Nome . ' ' . ($debug ? $opzione->voti : '') }}
                                            </label>
                                        </h4>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <button type="button" id="triggerSwalText" data-title="Un ultimo step..." data-text="Inserisci codice di voto" data-ConfirmBtn="Vota!" data-CancelBtn="Annulla" class="col-sm-12 btn-lg btn-primary btn-block">Prosegui</button>
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
