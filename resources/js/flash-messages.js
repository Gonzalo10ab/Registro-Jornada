import Swal from "sweetalert2";
window.Swal = Swal;

document.addEventListener("DOMContentLoaded", function () {
    if (window.flashMessage) {
        Swal.fire({
            title: "¡Éxito!",
            text: window.flashMessage,
            icon: "success",
            timer: 1500,
            showConfirmButton: false
        });
    }

    if (window.flashError) {
        Swal.fire({
            title: "¡Error!",
            text: window.flashError,
            icon: "error",
            timer: 2000,
            showConfirmButton: false
        });
    }

    if (window.flashWarning) {
        Swal.fire({
            title: "¡Aviso!",
            text: window.flashWarning,
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
        });
    }
});

