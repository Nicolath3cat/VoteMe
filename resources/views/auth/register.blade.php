@extends('layouts.app')

@section('title')
    Register
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="col-md-12 form-group">
                    <label for="name">Nome</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-12 form-group">
                    <label for="email">Indirizzo email</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-12 form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ruolo" id="ruolo1" value="1">
                        <label class="form-check-label" for="ruolo1">
                            Scrutatore
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ruolo" id="ruolo2" value="2">
                        <label class="form-check-label" for="ruolo2">
                            Accoglienza
                        </label>
                    </div>
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
