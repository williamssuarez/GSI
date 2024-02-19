<?php $datos = $equipos->getDataIngreso() ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> new!</h1>
 <p class="mb-4">Ingrese los datos del nuevo equipo en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" >Ingresar Equipo <i class="fa-solid fa-computer"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="" method="post">


            <div>
                <label class="form-label mt-4"><i class="fa-solid fa-tag" style="color: #279608;"></i> Numero de Bien</label>
                <input required class="form-control" type="number" name="numero_bien" id="numero_bien" maxlength="6" minlength="6" placeholder="Introduzca Numero de Bien">
                <div id="mensajeBienValidacion" class="form-text"></div>

                <label class="form-label mt-4"><i class="fa-solid fa-calendar-days"></i> Fecha Recibido</label>
                <input class="form-control" required type="datetime-local" name="fecha_recibido" id="fecha_recibido" value="" max="" min="2020-01-01T00:00"> 

                    <label class="form-label mt-4"><i class="fa-solid fa-user-gear" style="color: #005af5;"></i> Recibido Por</label>
                    <select required class="form-select" name="recibido_por" id="recibido_por">
                            
                            <?php foreach($datos['operadores'] as $operadores) {  ?>
                                <option value="<?php echo $operadores['id_user']; ?>"> <?php echo $operadores['nombre'] ?> <?php echo $operadores['apellido']?> </option>
                            <?php } ?>

                    </select>

        
                
                <div class="form-group">
                    <label class="form-label mt-4"><i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i> Problema</label>
                        <textarea required type="text" class="form-control" name="problema" id="problema" placeholder="Cual es el problema del equipo" rows="3"></textarea>
                        <div id="mensajeValidacion" class="form-text"></div>
                </div>
                
                
                <br>

                <button id="btnSubmit" class="btn btn-success" type="submit" disabled>
                <i class="fa-solid fa-truck-arrow-right fa-flip-horizontal"></i>
                    Ingresar
                </button>

            </div>

            </form>

        </div>
    </div>
</div>


<script src="<?php echo URL; ?>Views/template/js/scripts/getFechaActual.js" ></script>
<script>

    // Obtén el elemento del textarea y el botón submit
    const inputTexto = document.getElementById('problema');
    const btnSubmit = document.getElementById('btnSubmit');
    const numeroBienInput = document.getElementById('numero_bien');
    const mensajeValidacion = document.getElementById('mensajeValidacion');

    // Agrega un evento de entrada al textarea para validar en tiempo real
    inputTexto.addEventListener('input', function () {
        // Obtiene el valor del textarea y cuenta la longitud
        const valor = problema.value.trim();
        const longitud = valor.length;
        
        // Validación: no más de 200 caracteres
        if (longitud <= 200) {
            // Cambia el estilo y habilita el botón submit
            inputTexto.classList.remove('is-invalid');
            inputTexto.classList.add('is-valid');
            mensajeValidacion.textContent = '';
            btnSubmit.disabled = false;
        } else {
            // Cambia el estilo y deshabilita el botón submit
            inputTexto.classList.remove('is-valid');
            inputTexto.classList.add('is-invalid');
            mensajeValidacion.textContent = 'El texto no debe exceder los 200 caracteres.';
            btnSubmit.disabled = true;
        }
    });

    numeroBienInput.addEventListener('input', function() {
        console.log('si entra a la funcion');
        const newValue = this.value;
        const url = URL + 'ajax/comprobarBien';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        const data = `numero_bien=${newValue}`;
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Exitoso el ajax');
                const response = JSON.parse(xhr.responseText); // Assuming JSON response

                if (response === 1) {
                    numeroBienInput.classList.remove('is-invalid');
                    numeroBienInput.classList.add('is-valid');
                    //document.getElementById('btnSubmit').disabled = false;
                    btnSubmit.disabled = false;
                    //mensajeValidacion.textContent = '';
                    document.getElementById('mensajeBienValidacion').textContent = 'El equipo esta registrado.';
                } else {
                    numeroBienInput.classList.remove('is-valid');
                    numeroBienInput.classList.add('is-invalid');
                    //document.getElementById('btnSubmit').disabled = true;
                    btnSubmit.disabled = true;
                    document.getElementById('mensajeBienValidacion').textContent = 'Este equipo no esta registrado, registrelo para poder ingresarlo.';
                }
            } else {
                console.error('Error en el ajax:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Error en la red');
        };

        xhr.send(data);
    });


    /*numeroBienInput.addEventListener('change', function () {
    //$('#numero_bien').on("change", function() {
        console.log('si entra a la funcion');
        var newValue = $(this).val();
        var URL = "http://localhost/GSI/";
        $.ajax({
            url: URL + "ajax/comprobarBien",
            type: "POST",
            data: { numero_bien: numeroBienValue },
            success: function(response) {
                // Handle successful response
                console.log('Exitoso el ajax');

                if(response === 1){
                    $("#numero_bien").removeClass("is-invalid");
                    $("#numero_bien").addClass("is-valid");
                    $('#btnSubmit').removeAttr("disabled");
                } else {
                    $("#numero_bien").removeClass("is-valid");
                    $("#numero_bien").addClass("is-invalid")
                    $('#btnSubmit').attr("disabled", true);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error en el ajax');
            }
        });

    });*/



</script>
<?php
    require_once "Views/footers/footer.php";
?>


