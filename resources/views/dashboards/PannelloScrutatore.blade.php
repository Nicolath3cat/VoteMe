@extends('layouts.dashboard')

@section('title')
    Pannello scrutatore
@endsection



@section('Tabs')
    <div class="container">
        @if (session('toast'))
            <div class="row justify-content-md-center">
                <div class="alert alert-danger col-md-5">
                    {{ session('toast') }}
                </div>
            </div>
        @endif
        <div class="row justify-content-md-center m-3">
        </div>
        <form method="POST" class="form" action="{{ route('toggleVotazioni') }}">
            <div class="row justify-content-md-left">
                @csrf
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                {{ $votanti . '/' . $minimo_quorum }}
                            </span>
                        </div>
                        @if($settings->where('Nome', 'accetta_voti')->first()->Valore == '1')
                            <button type="button" data-title="Attenzione!" data-text="Stai per chiudere le votazioni, confermi?" class="btn btn-danger triggerSwal">
                                Chiudi votazioni
                            </button>
                        @else
                            <input type="hidden" name="tipo_votazione" id="tipo" value="">
                            <button type="button" id="triggerSwalChoice"
                                class="btn btn-success col-md-5 {{ $Quorum_raggiunto ?: 'disabled' }}">Apri
                                Votazioni</button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <ul class="nav nav-tabs" role="tablist">
            @if ($settings->where('Nome', 'accetta_voti')->first()->Valore == '1')
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#stato" role="tab">Stato Votazioni</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{ $settings->where('Nome', 'accetta_voti')->first()->Valore == '1' ?: 'active' }}"
                    data-toggle="tab" href="#elezioni" role="tab">Elezioni</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#referendum" role="tab">Referendum</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            @if ($settings->where('Nome', 'accetta_voti')->first()->Valore == '1')
                <div class="tab-pane active" id="stato" role="tabpanel">
                    @yield('stato')
                </div>
            @endif
            <div class="tab-pane {{ $settings->where('Nome', 'accetta_voti')->first()->Valore == '1' ?: 'active' }}"
                id="elezioni" role="tabpanel">
                @yield('elezioni')
            </div>
            <div class="tab-pane" id="referendum" role="tabpanel">
                @yield('referendum')
            </div>
        </div>
    </div>
@endsection
