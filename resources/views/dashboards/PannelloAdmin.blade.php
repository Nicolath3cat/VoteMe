@extends('layouts.dashboard')

@section('title')
    Amministrazione
@endsection

@section('Tabs')
    <div class="container">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#register" role="tab">Registra</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#data" role="tab">Dati</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="register" role="tabpanel">
                @yield('register')
            </div>
            <div class="tab-pane" id="data" role="tabpanel">
                @yield("data")
            </div>
        </div>
    </div>
@endsection
