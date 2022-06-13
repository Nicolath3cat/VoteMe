import swal from 'sweetalert2';
window.Swal = swal;

$(function () {
    $("#triggerSwalText").on("click", function () {
        const {
            value: voteCode
        } = Swal.fire({
            title: $(this).data("title"),
            input: "text",
            inputLabel: $(this).data("text"),
            confirmButtonText: $(this).data("confirmbtn") || "Conferma",
            showDenyButton: true,
            denyButtonText: $(this).data("cancelbtn") || "Annulla",
            inputValidator: (value) => {
                if (!value) {
                    return "Inserisci il codice di voto!";
                }
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $("input#voteCode").val(result.value);
                $("#form").trigger("submit");
            } else if (result.isDenied) {
                Swal.fire("Annullato, puoi continuare", "", "info");
            }
        });
    });
});

$(function () {
    $(".triggerSwal").on("click", function () {
        Swal.fire({
            title: $(this).data("title"),
            text: $(this).data("text"),
            confirmButtonText: $(this).data("confirmbtn") || "Conferma",
            showDenyButton: true,
            denyButtonText: $(this).data("cancelbtn") || "Annulla",
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).closest('form').trigger("submit");
            } else if (result.isDenied) {
                Swal.fire("Annullato, puoi continuare", "", "info");
            }
        });
    });
});


$(function () {
            $("#triggerSwalChoice").on("click", function () {
                const inputOptions = new Promise((resolve) => {
                    setTimeout(() => {
                        resolve({
                            'elezioni': 'Elezioni',
                            'referendum': 'Referendum'
                        })
                    }, 1000)
                })

                const {value: tipo} = Swal.fire({
                    title: 'Che tipo di votazione di tratta?',
                    input: 'radio',
                    inputOptions: inputOptions,
                    inputValidator: (value) => {
                        if (!value) {
                            return "Scegli un'opzione!"
                        }
                    }
                }).then((result) => {
                if(result.value != null){
                    $("input#tipo").val(result.value);
                    $(this).closest('form').trigger("submit");
                }});
            });
        });


