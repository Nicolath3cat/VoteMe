@extends('layouts.app')

@section('title')
    Login
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
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="col-md-12 form-group">
                    <label for="email">E-Mail Address</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-12 form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-12 form-group">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
