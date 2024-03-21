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
                <input required class="form-control" type="number" name="numero_bien2" id="numero_bien2" maxlength="6" minlength="6" placeholder="Introduzca Numero de Bien">
                <div id="mensajeBienValidacion" class="form-text"></div>

                <label class="form-label mt-4"><i class="fa-solid fa-calendar-days"></i> Fecha Recibido</label>
                <input class="form-control" required type="datetime-local" name="fecha_recibido" id="fecha_recibido" value="" max="" min="2020-01-01T00:00"> 

                    <label class="form-label mt-4"><i class="fa-solid fa-user-gear" style="color: #005af5;"></i> Recibido Por</label>
                    <select required class="form-select Select2" name="recibido_por" id="recibido_por">
                            
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
<script src="<?php echo URL; ?>Views/template/js/scripts/forms/equiposIngreso.js" ></script>

<script>
    const inputTexto = document.getElementById('problema');

    //VALIDAR TEXTAREA
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
</script>
<?php
    require_once "Views/footers/footer.php";
?>


