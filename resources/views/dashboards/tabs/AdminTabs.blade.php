@extends("dashboards.PannelloAdmin")

@section("data")
    <div class="container">
        <div class="row justify-content-md-center">
            <form method="POST" action="{{ route('clearData') }}">
                @csrf
                <div class="col-md-6 mt-3 form-group">
                    <input type="checkbox" class="form-check-input" name="Candidati" id="Candidati">
                    <label class="form-check-label" for="Candidati">
                        Cancella tutti i candidati
                    </label>
                </div>
                <div class="col-md-6  form-group">
                    <input type="checkbox" class="form-check-input" name="Opzioni" id="Opzioni">
                    <label class="form-check-label" for="Opzioni">
                        Cancella tutte le opzioni
                    </label>
                </div>
                <div class="col-md-6  form-group">
                    <input type="checkbox" class="form-check-input" name="Codici" id="Codici">
                    <label class="form-check-label" for="Codici">
                        Cancella tutti i codici
                    </label>
                </div>
                <div class="col-md-6  form-group">
                    <input type="checkbox" class="form-check-input" name="Utenti" id="Utenti">
                    <label class="form-check-label" for="Utenti">
                        Cancella tutti gli utenti
                    </label>
                </div>
                <div class="col-md-6  form-group">
                    <input type="checkbox" class="form-check-input" name="Impostazioni" id="Impostazioni">
                    <label class="form-check-label" for="Impostazioni">
                        Reset di tutte le impostazioni
                    </label>
                </div>
                <div class="col-md-6 mt-3 form-group">
                    <input type="checkbox" class="form-check-input" name="Presenze" id="Presenze">
                    <label class="form-check-label" for="Presenze">
                        Elimina tutte le presenze
                    </label>
                </div>
                <input type="submit" class="btn btn-primary" value="Conferma">
            </form>
        </div>
    </div>
@endsection


@section('register')
    <div class="container">
        <div class="row justify-content-md-center">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="col-md-12 form-group">
                    <label for="name">Nome</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-12 form-group">
                    <label for="email">Indirizzo email</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-12 form-group">
                    @foreach ($ruoli as $ruolo)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ruolo" id="{{ $ruolo->Nome }}" value="{{ $ruolo->id }}">
                        <label class="form-check-label" for="{{ $ruolo->Nome }}">
                            {{ $ruolo->Nome }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-12 form-group">
                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection