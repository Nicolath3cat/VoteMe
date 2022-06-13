@extends('layouts.dashboard')

@section('title')
    Pannello segretario
@endsection
@section('Tabs')
    <div class="container">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#entrate" role="tab">Entrate</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#uscite" role="tab">Uscite</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="entrate" role="tabpanel">
                @yield('entrate')
            </div>

            <div class="tab-pane" id="uscite" role="tabpanel">
                @yield('uscite')
            </div>
        </div>
    </div>
@endsection
