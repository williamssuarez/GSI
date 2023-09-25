document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const nombre = document.getElementById("nombre");
    const apellido = document.getElementById("apellido");
    const cedula = document.getElementById("cedula_identidad");
    const correo = document.getElementById("correo");
    const submitButton = document.querySelector("button[type='submit']");

    form.addEventListener("submit", function (event) {
        let valid = true;

        if (nombre.value.trim() === "") {
            valid = false;
        }

        if (apellido.value.trim() === "") {
            valid = false;
        }

        if (cedula.value.trim() === "" || isNaN(cedula.value)) {
            valid = false;
        }

        if (correo.value.trim() === "" || !isValidEmail(correo.value)) {
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); // Evita que se envíe el formulario
        }
    });

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
