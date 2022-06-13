@extends('dashboards.PannelloScrutatore')

@section('elezioni')
    <div class="row m-3">
        <button type="button" data-url="{{ route('ModificaCandidati') }}" class="btn btn-secondary modalTrigger">
            Opzioni Elezioni
        </button>
    </div>
    <div class="row justify-content-md-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Risultato ultime elezioni</h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-md-12">
                            <canvas id="ElezioniChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- chartjs script --}}
    <script>
        $('#ElezioniChart').ready(function() {
            var arrayLabel = [
                @foreach ($candidati as $candidato)
                    '{{ $candidato->Nome . ' ' . $candidato->Cognome }}',
                @endforeach
            ];
            var arrayData = [
                @foreach ($candidati as $candidato)
                    {{ $candidato->voti }},
                @endforeach
            ];

            arrayOfObj = arrayLabel.map(function(d, i) {
                return {
                    label: d,
                    data: arrayData[i] || 0
                };
            });

            sortedArrayOfObj = arrayOfObj.sort(function(a, b) {
                return b.data > a.data;
            });
            newArrayLabel = [];
            newArrayData = [];
            sortedArrayOfObj.forEach(function(d) {
                newArrayLabel.push(d.label);
                newArrayData.push(d.data);
            });
            var ctx = document.getElementById('ElezioniChart').getContext('2d');
            //column stack chart
            const data = {
                labels: newArrayLabel,
                datasets: [{
                    data: newArrayData,
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
                    scales: {
                        animation: false,
                        yAxes: [{
                            display: true,
                            ticks: {
                                suggestedMin: 0,
                            }
                        }]
                    },
                    plugins: {
                        legend: {
                            display: false,
                        }
                    }
                }
            };
            var myChart = new Chart(ctx, config);
        })
    </script>
@endsection


@section('referendum')
    <div class="row m-3">
        <button type="button" data-url="{{ route('ModificaOpzioni') }}" class="btn btn-secondary modalTrigger">
            Opzioni Referendum
        </button>
    </div>
    <div class="container">
        @if (session('toast'))
            <div class="row justify-content-md-center">
                <div class="alert alert-danger col-md-5">
                    {{ session('toast') }}
                </div>
            </div>
        @endif
        <div class="row justify-content-md-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Risultato ultimo referendum</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-md-center">
                            <div class="col-md-12">
                                <canvas id="ReferendumChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- chartjs script --}}
    <script>
        $('#ReferendumChart').ready(function() {
            var arrayLabel = [
                @foreach ($opzioni as $opzione)
                    '{{ $opzione->Nome }}',
                @endforeach
            ];
            var arrayData = [
                @foreach ($opzioni as $opzione)
                    {{ $opzione->voti }},
                @endforeach
            ];

            arrayOfObj = arrayLabel.map(function(d, i) {
                return {
                    label: d,
                    data: arrayData[i] || 0
                };
            });

            sortedArrayOfObj = arrayOfObj.sort(function(a, b) {
                return b.data > a.data;
            });

            newArrayLabel = [];
            newArrayData = [];
            sortedArrayOfObj.forEach(function(d) {
                newArrayLabel.push(d.label);
                newArrayData.push(d.data);
            });


            var ctx = document.getElementById('ReferendumChart').getContext('2d');
            //column stack chart
            const data = {
                labels: newArrayLabel,
                datasets: [{
                    data: newArrayData,
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
                    scales: {
                        animation: false,
                        yAxes: [{
                            display: true,
                            ticks: {
                                suggestedMin: 0,
                            }
                        }]
                    },
                    plugins: {
                        legend: {
                            display: false,
                        }
                    }
                }
            };
            var myChart = new Chart(ctx, config);
        });
    </script>
@endsection

@section('stato')
    <div class="container mt-3">
        <!--candidates list-->
        <div class="row">
            @if (count($Inutilizzati) > 0)
                @foreach ($Inutilizzati as $Inutilizzato)
                    @php
                        $Partecipante = DB::table('Presenze')
                            ->where('id', $Inutilizzato->Gruppo)
                            ->first();
                        $Codici = explode(',', $Inutilizzato->Codici);
                    @endphp
                    <div class="col-md-6">
                        <div class="row m-2 border border-warning rounded">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">{{ $Partecipante->Nome . ' ' . $Partecipante->Cognome }}
                                    </div>
                                    <div class="col-md-12">{{ $Partecipante->Email }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                @foreach ($Codici as $Codice)
                                    <div class="row">
                                        <div class="col">{{ $Codice }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row">
                    <div class="col-md">
                        <div class="alert alert-success justify-center">
                            Tutti i codici sono stati utilizzati!
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script>
        $(".modalTrigger").on("click", function() {
            $.ajax({
                url: $(this).data("url"),
                success: function(response) {
                    $('.modal-content').html(response);
                    $('.modal').modal('show');
                }
            })
        })
    </script>
@endsection
