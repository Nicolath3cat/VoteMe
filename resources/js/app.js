require("./bootstrap");
import $ from "jquery";
const Swal = require("sweetalert2");
window.$ = window.jQuery = $;

$(function () {
    $("#vota").on("click", function () {
        const { value: voteCode } = Swal.fire({
            title: "Inserisci il codice di voto",
            input: "text",
            inputLabel: "codice di voto",
            showCancelButton: true,
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
