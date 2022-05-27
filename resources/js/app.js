require("./bootstrap");
import $ from "jquery";
const Swal = require("sweetalert2");
window.$ = window.jQuery = $;

$(function () {
    $("#triggerSwalText").on("click", function () {
        const { value: voteCode } = Swal.fire({
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
            if (result.isConfirmed){
                $("input#voteCode").val(result.value);
                $("#form").trigger("submit");
            } else if (result.isDenied) {
                Swal.fire("Annullato, puoi continuare", "", "info");
            }
        });
    });
});

$(function () {
    $("#triggerSwal").on("click", function () {
        const { value: voteCode } = Swal.fire({
            title: $(this).data("title"),
            confirmButtonText: $(this).data("confirmbtn") || "Conferma",
            showDenyButton: true,
            denyButtonText: $(this).data("cancelbtn") || "Annulla",
        }).then((result) => {
            if (result.isConfirmed){
                $("input#voteCode").val(result.value);
                $(this).closest('form').trigger("submit");
            } else if (result.isDenied) {
                Swal.fire("Annullato, puoi continuare", "", "info");
            }
        });
    });
});
