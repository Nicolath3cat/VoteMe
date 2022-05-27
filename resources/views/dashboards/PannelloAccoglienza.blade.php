@extends('layouts.app')

@section('title')
    Control Panel
@endsection

@section('content')
    <div class="container">
        {{-- error message for incorrect credentials --}}
        @if (session('toast'))
        <div class="row justify-content-md-center">
            <div class="alert alert-danger col-md-5">
                    {{ session('toast') }}
            </div>
        </div>
        @endif
        <div class="row justify-content-md-center">
            <form method="POST" action="{{ route('codeGen') }}">
                @csrf
                <div class="col-md-12 form-group">
                    <label for="email">Email Partecipante</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-12 form-group">
                    <label for="deleghe">Numero di Deleghe</label>
                    <input id="deleghe" type="number" class="form-control @error('deleghe') is-invalid @enderror"
                        name="deleghe">
                    @error('deleghe')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-12 form-group">
                    <button type="submit" class="btn btn-primary">
                        Segna presenza ed invia codici
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


