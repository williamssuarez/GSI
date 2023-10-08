$(document).ready( function () {
    $('#tablausuarios').DataTable({
        language: {
            lengthMenu: "Mostrar _MENU_ registros por pagina",
            zeroRecords: "Ningun operador encontrado",
            info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Ningun operador encontrado",
            infoFiltered: "(filtrados desde _MAX_ registros totales)",
            search: "Buscar: ",
            loadingRecords: "Cargando... ",
            paginate: {
                first: "Primero",
                last: "Ultimo", 
                next: "Siguiente",
                previous: "Anterior"
            }
        }
    })
    
    $("#desactivar").on("click", function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace.
    
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Si decides desactivar esta cuenta de operador, el usuario no podra iniciar sesion hasta ser reactivado",
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

    $("#reactivar").on("click", function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace.
    
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Reactivar este operador lo volvera parte de los demas procesos del sistema ¿Estás seguro?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, seguro",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirmó, redirige al enlace del botón.
                window.location.href = $(this).attr("href");
            }
        });
    });
    
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
} );