$(document).ready( function () {
    $('#tablaequipos_ingresados').DataTable({
        order: [[2, 'desc']],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por pagina",
            zeroRecords: "Ningun equipo encontrado",
            info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Ningun equipo encontrado",
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
    });
    $("#EntregarOperador").on("click", function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace.
    
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Solo puedes entregar cuando el equipo este completamente listo",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, esta listo",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirmó, redirige al enlace del botón.
                window.location.href = $(this).attr("href");
            }
        });
    });
} );