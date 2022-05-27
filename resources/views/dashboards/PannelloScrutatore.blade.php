@extends('layouts.app')
@php
$settings = DB::table('Settings');
@endphp

@section('title')
    Control Panel
@endsection


@if ((int) $settings->where('Nome', 'accetta_voti')->first()->Valore)
    @section('content')
        <div class="container">
            @if (session('toast'))
                <div class="row justify-content-md-center">
                    <div class="alert alert-danger col-md-5">
                        {{ session('toast') }}
                    </div>
                </div>
            @endif
            <div class="row justify-content-md-center">
                <form method="POST" action="{{ route('toggleVotazioni') }}">
                    @csrf
                    <div class="col-md-12 form-group">
                        <button type="button" id="triggerSwal" data-title="Chiudere le votazioni?"
                            class="btn btn-danger btn-block">Chiudi votazioni</button>
                    </div>
                </form>
            </div>
            <div class="row justify-content-md-center">
                <div class="alert alert-warning col-md-5">
                    <h4 class="text-center">Chiudi le votazioni prima di vedere i risultati</h4>
                </div>
            </div>
        </div>
    @endsection
@else
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    @section('content')
        @php
            $settings = DB::table('Settings');
        @endphp
        <div class="container">
            @if (session('toast'))
                <div class="row justify-content-md-center">
                    <div class="alert alert-danger col-md-5">
                        {{ session('toast') }}
                    </div>
                </div>
            @endif
            <div class="row justify-content-md-center">
                <form method="POST" action="{{ route('toggleVotazioni') }}">
                    @csrf
                    <div class="col-md-12 form-group">
                        <button class="btn btn-success btn-block">Apri votazioni</button>
                    </div>
                </form>
            </div>
            <div class="row justify-content-md-center">
                {{-- charting with chartjs --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Votazioni</h4>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-md-center">
                                <div class="col-md-12">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- chartjs script --}}
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            //column stack chart
            const data = {
                labels: [
                    @foreach ($candidati as $candidato)
                        '{{ $candidato->Nome . ' ' . $candidato->Cognome }}',
                    @endforeach
                ],
                datasets: [{
                    label: '',
                    data: [
                        @foreach ($candidati as $candidato)
                            {{ $candidato->voti }},
                        @endforeach
                    ],
                    backgroundColor: [
                        '#aaaaaa',
                        '#262626',
                        '#ffcd55',
                        '#ff8c8c',
                        '#4bc3c3',
                        '#9b64ff',
                        '#ffa041',

                    ],
                    borderWidth: 1
                }]
            };
            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        legend: {
                            display: false,
                        }
                    }
                }
            };

            var myChart = new Chart(ctx, config);
        </script>
    @endsection
@endif
