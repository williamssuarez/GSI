$(document).ready(function(){
    // Get value on button click and show alert
    $("#myBtn").click(function(){
        var str = $("#myInput").val();
        alert(str);
    });

    $("#departamento").change(function(){
        const selectedDeptId = $(this).val();

        console.log(selectedDeptId);

        // Destroy existing options in the employee select (optional)
        $('#usuario').empty();

        $.ajax({
            url: URL + 'ajax/getEmpleadosByDpto/' + selectedDeptId,
            type: 'GET',
            //data: { departamento_id: selectedDeptId }, 
            success: function(response) {
                // Parse the response (assuming JSON format)
                
                console.log(response);
                /*const employees = JSON.parse(response);
        
                // Loop through employees and add options to the select
                $.each(employees, function(index, employee) {
                  const option = $('<option>')
                    .val(employee.id_empleado)
                    .text(employee.nombre_completo + ' - C.I: ' + employee.cedula);
        
                  $('#usuario').append(option);
                });
        
                // Initialize employee select2 (optional)
                $('#usuario').select2();*/
              }
        })
    });
});