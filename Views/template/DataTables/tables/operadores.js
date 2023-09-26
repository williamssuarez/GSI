$(document).ready( function () {
    $('#tablaoperadores').DataTable({
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
    $("#suspendiendo").on("click", function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace.
    
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¿Deseas suspender a este operador?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, suspender",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirmó, redirige al enlace del botón.
                window.location.href = $(this).attr("href");
            }
        });
    });

    $("#reactivando").on("click", function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace.
    
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¿Deseas reactivar a este operador?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, reactivar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirmó, redirige al enlace del botón.
                window.location.href = $(this).attr("href");
            }
        });
    });
    $("#eliminando").on("click", function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace.
    
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¿Deseas eliminar a este operador?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirmó, redirige al enlace del botón.
                window.location.href = $(this).attr("href");
            }
        });
    });
} );