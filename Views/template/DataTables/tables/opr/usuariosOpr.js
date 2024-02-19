$("#editarpreguntasseguridad").on("click", function (e) {
    e.preventDefault(); // Evita el comportamiento predeterminado del enlace.

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Si decides editar, tendras que volver a introducir todas las respuestas a las preguntas, y una vez echo no se podra volver",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, entiendo",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            // Si se confirmó, redirige al enlace del botón.
            window.location.href = $(this).attr("href");
        }
    });
});


$("#editarcredenciales").on("click", function (e) {
    e.preventDefault(); // Evita el comportamiento predeterminado del enlace.

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Al editar las credenciales tendras que volver a iniciar sesion",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, editar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            // Si se confirmó, redirige al enlace del botón.
            window.location.href = $(this).attr("href");
        }
    });
});