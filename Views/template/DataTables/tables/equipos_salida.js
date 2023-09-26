$(document).ready( function () {
    $('#tablaequipos_salida').DataTable({
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
    })
} );