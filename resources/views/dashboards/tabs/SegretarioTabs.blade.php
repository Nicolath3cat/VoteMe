@extends('dashboards.PannelloSegretario')

@section('entrate')
    <div class="container">
        {{-- error message for incorrect credentials --}}
        @if (session('toast'))
            <div class="row justify-content-center">
                <div class="alert alert-danger col-md-5">
                    {{ session('toast') }}
                </div>
            </div>
        @endif
        <form method="POST" action="{{ route('entrata') }}">
            <div class="row">
                @csrf
                <div class="col-md-auto form-group">
                    <label for="Nome">Nome</label>
                    <input id="Nome" type="text" class="form-control @error('Nome') is-invalid @enderror" name="Nome"
                        value="{{ old('Nome') }}" autocomplete="Nome">
                    @error('Nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-auto form-group">
                    <label for="Cognome">Cognome</label>
                    <input id="Cognome" type="text" class="form-control @error('Cognome') is-invalid @enderror"
                        name="Cognome" value="{{ old('Cognome') }}" autocomplete="Cognome">
                    @error('Cognome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-auto form-group">
                    <label for="Email">Email Partecipante</label>
                    <input id="Email" type="text" class="form-control @error('Email') is-invalid @enderror" name="Email"
                        value="{{ old('Email') }}" autocomplete="Email">
                    @error('Email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-auto form-group">
                    <label for="Deleghe">Numero di Deleghe</label>
                    <input id="Deleghe" type="number" class="form-control @error('Deleghe') is-invalid @enderror"
                        name="Deleghe">
                    @error('Deleghe')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-auto form-group">
                    <button type="submit" class="btn btn-primary">
                        Segna presenza ed invia codici
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('uscite')
    <div class="container mt-3">
        @if (count($Presenze) > 0)
            <div class="row">
                @foreach ($Presenze as $Presente)
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('uscita') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $Presente->id }}">
                            <div class="input-group">
                                <input type="submit" class="form-control btn btn-danger col-md-2" value="Uscita">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $Presente->Nome . ' ' . $Presente->Cognome }}</span>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                Registra qualche entrata prima di utilizzare questa scheda
            </div>
        @endif
    </div>
@endsection
