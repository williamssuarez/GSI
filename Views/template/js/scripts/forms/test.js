$(document).ready(function(){
    
    //REGISTRO DE EQUIPOS
    $("#departamento").change(function(){
        const selectedDeptId = $(this).val();

        // VACIAR EL SELECT
        $('#usuario').empty();

        $.ajax({
            url: URL + 'ajax/getEmpleadosByDpto/' + selectedDeptId,
            type: 'GET',
            //data: { departamento_id: selectedDeptId }, 
            success: function(response) {

                // PARSEANDO A JSON POR SI ACASO
                const employees = JSON.parse(response);
        
                if (employees.length === 0) {
                    //NO SE ENCONTRARON EMPLEADOS
                    const noEmployeeOption = $('<option>')
                    .text('Ningun empleado registrado en este departamento, registrelos');

                    $('#usuario').append(noEmployeeOption);
                } else {
                  //EMPLEADOS ENCONTRADOS, LLENAR SELECT2
                  $.each(employees, function(index, employee) {
                    const option = $('<option>')
                      .val(employee.id_empleado)
                      .text(employee.nombre_completo + ' - C.I: ' + employee.cedula);
          
                    $('#usuario').append(option);
                  });
          
                  //REINICIALIZAR SELECT2
                  $('#usuario').select2();
                }
              }
        })
    });

    //REGISTRO DE EQUIPOS
    $("#numero_bien").keyup(function() {
      const numeroBien = $(this).val();
  
      // Removiendo estilos de validacion previos
      $(this).removeClass("is-valid is-invalid");
      $("#mensajeBienValidacion").text("");
  
      // Validar si es unico el registro
      $.ajax({
        url: URL + 'ajax/checkBMforRegistro/' + numeroBien,
        type: 'GET',
        //data: { numero_bien: numeroBien },
        success: function(response) {

          if (response === 'true') {
            // Numero no registrado, permitir nuevo registro
            $("#numero_bien").addClass("is-valid");
            $("#mensajeBienValidacion").text("El numero de bien no esta registrado, puede ingresarlo");
            $("#btnSubmit").removeAttr("disabled"); // Habilitar boton
          } else {
            // Numero ya registrado, no permitir nuevo registro
            $("#numero_bien").addClass("is-invalid");
            $("#mensajeBienValidacion").text("Ya hay un equipo registrado con este numero de bien");
            $("#btnSubmit").attr("disabled", true); // Deshabilitar boton
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error("Error:", textStatus, errorThrown);
          // Handle AJAX request errors (optional)
        }
      });
    });

    //REGISTRO DE EQUIPOS
    $("#direccion_mac").keyup(function() {
      const direccionMac = $(this).val();
  
      // Removiendo estilos de validacion previos
      $(this).removeClass("is-valid is-invalid");
      $("#mensajeMACValidacion").text("");
  
      // Validar si es unico el registro
      $.ajax({
        url: URL + 'ajax/checkMACforRegistro/' + direccionMac,
        type: 'GET',
        //data: { numero_bien: numeroBien },
        success: function(response) {

          if (response === 'true') {
            // Numero no registrado, permitir nuevo registro
            $("#direccion_mac").addClass("is-valid");
            $("#mensajeMACValidacion").text("La direccion no esta registrada, puede ingresarla");
            $("#btnSubmit").removeAttr("disabled"); // Habilitar boton
          } else {
            // Numero ya registrado, no permitir nuevo registro
            $("#direccion_mac").addClass("is-invalid");
            $("#mensajeMACValidacion").text("Ya hay un equipo registrado con esta direccion MAC");
            $("#btnSubmit").attr("disabled", true); // Deshabilitar boton
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error("Error:", textStatus, errorThrown);
          // Handle AJAX request errors (optional)
        }
      });
    });

    //INGRESO DE EQUIPOS
});