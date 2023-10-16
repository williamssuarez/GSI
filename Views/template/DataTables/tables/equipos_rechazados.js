$(document).ready( function () {

    $('#tablaequipos_rechazados').DataTable({
        language: {
            lengthMenu: "Mostrar _MENU_ registros por pagina",
            zeroRecords: "No hay entregas rechazadas",
            info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
            infoEmpty: "No hay entregas rechazadas",
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
    
} );