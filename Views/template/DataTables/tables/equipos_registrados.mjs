//IMPORTANDO PLANTILLA PDF
import pdfTemplate from "../GSI/Views/template/DataTables/extensions/js/pdf/pdfTemplate";

$(document).ready( function () {
    $('#tablaequipos_registrados').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Excel',
                className: 'btn btn-success',
                title: 'Equipos Registrados'
            },
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                className: 'btn btn-danger',
                title: 'Equipos Registrados',
                pageSize: 'letter', //TAMAÑO DE LA HOJA, CARTA EN ESTE CASO
                exportOptions: { //OPCIONES DE EXPORTACION
                    search: 'applied', //Para aceptar reporte de una busqueda
                    order: 'applied', //Para mantener el orden aplicado en la datatable
                    stripNewlines: false //Para mantener saltos de linea (ignorados en este caso)
                },
                customize: pdfTemplate
            },
        ],
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

    $("#reactivandoequipo").on("click", function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace.
    
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¿Deseas reactivar este equipo?",
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
    $("#desactivandoequipo").on("click", function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace.
    
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¿Deseas desactivar este equipo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, desactivar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirmó, redirige al enlace del botón.
                window.location.href = $(this).attr("href");
            }
        });
    });
} );