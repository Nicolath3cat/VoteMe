<div class="modal-header">
    <h5 class="modal-title">Gestione opzioni</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>

    <body>
        <form action="{{ route('ModificaOpzioni') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Titilo sessione</span>
                        <input type="text" class="form-control" value="{{ DB::table("Settings")->where("Nome","titolo_referendum")->first()->Valore}}" name="Domanda" placeholder="es. Sei favorevole all'iniziativa?" required>
                    </div>
                </div>
            </div>
            @if (count($opzioni) > 0)
                @foreach ($opzioni as $opzione)
                    <div class="row dynamicInput">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Nome</span>
                                <input type="text" class="form-control" value="{{ $opzione->Nome }}" name="opzioni[]"
                                    placeholder="Nome" required>
                            </div>
                        </div>
                        <div class="col-sm">
                            <button class="btn btn-danger" id="DeleteRow" type="button">
                                <span class="material-icons">Elimina</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row dynamicInput">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Nome</span>
                            <input type="text" class="form-control" name="opzioni[]" placeholder="Nome" required>
                        </div>
                    </div>
                    <div class="col-sm">
                        <button class="btn btn-danger" id="DeleteRow" type="button">
                            <span class="material-icons">Elimina</span>
                        </button>
                    </div>
                </div>
            @endif
            <span id="newinput"></span>
            <button id="rowAdder" type="button" class="btn btn-primary">
                <span class="bi bi-plus-square-dotted">
                </span> Aggiungi opzione
            </button>
            <button type="submit" class="btn btn-success">Salva</button>
        </form>

    </body>
    <script>
        number = 0;
        $("#rowAdder").on("click", function() {
            number++;
            newRowAdd =
                ` <div class="row dynamicInput">
                <div class="col-sm">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Nome</span>
                        <input type="text" class="form-control" name="opzioni[]" placeholder="Nome" required>
                    </div>
                </div>
                <div class="col-sm">
                    <button class="btn btn-danger" id="DeleteRow" type="button">
                        <span class="material-icons">Elimina</span>
                    </button>
                </div>
            </div>`;
            $('#newinput').append(newRowAdd);
        });

        $("body").on("click", "#DeleteRow", function() {
            if ($(".dynamicInput").length > 1) {
                $(this).closest('.dynamicInput').remove();
            }
        });
    </script>

    </html>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
