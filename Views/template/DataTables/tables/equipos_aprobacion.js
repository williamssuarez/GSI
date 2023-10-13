$(document).ready( function () {
    $('#tablaequipos_aprobacion').DataTable({
        language: {
            lengthMenu: "Mostrar _MENU_ registros por pagina",
            zeroRecords: "Ningun equipo por aprobar",
            info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Ningun equipo por aprobar",
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

    $("#aprobar_entrega").on("click", function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace.
    
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¿Deseas aprobar la salida de este equipo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, aprobar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirmó, redirige al enlace del botón.
                window.location.href = $(this).attr("href");
            }
        });
    }); 
    $("#rechazar_entrega").on("click", function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace.
    
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¿Deseas rechazar la salida de este equipo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, rechazar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirmó, redirige al enlace del botón.
                window.location.href = $(this).attr("href");
            }
        });
    });
} );