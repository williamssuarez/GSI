<?php $datos = $dispositivos->getDataForRegistro();
?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> new!</h1>
 <p class="mb-4">Ingrese los datos de la nueva categoria en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Dispositivo <i class="fa-solid fa-print"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="new" method="post">

                <div>

                <label class="form-label mt-4"><i class="fa-solid fa-building" style="color: #913080;"></i> Seleccione un tipo de dispositivo. NOTA: Si el dispositivo requiere la asignacion de una direccion ip para funcionar o conectarse a la red entonces deberia ser de la categoria de redes</label>
                    <select required class="form-select Select2" name="tipo" id="tipo">

                        <?php foreach ($datos['tipos'] as $tipo) { ?>
                            <option value="<?php echo $departamento['id_tipo']; ?>"> <?php echo $tipo['nombre_tipo'] ?> </option>
                        <?php } ?>

                    </select>

                <label class="form-label mt-4">
                    <i class="fa-solid fa-tag" style="color: #279608;"></i> 
                        Inserte el numero de bien
                    </label>
                    <input required class="form-control" type="text" name="numero_bien_dispositivo" id="numero_bien_dispositivo" placeholder="Introduzca numero de bien">
                    <div id="mensajeBienValidacion" class="form-text"></div>

                    <label class="form-label mt-4">
                        <i class="fa-solid fa-copyright"></i>
                        Inserte el nombre de la marca (Opcional)
                    </label>
                    <input class="form-control" type="text" name="marca" id="marca" placeholder="Introduzca Marca">

                    <label class="form-label mt-4">
                        <i class="fa-solid fa-barcode"></i> 
                        Inserte el serial (Opcional)
                    </label>
                    <input class="form-control" type="text" name="serial" id="serial" placeholder="Introduzca Serial">

                    <label class="form-label mt-4">
                        <i class="fa-solid fa-database" style="color: #c00c0c;"></i> 
                        Inserte el modelo (Opcional)
                    </label>
                    <input class="form-control" type="text" name="modelo" id="modelo" placeholder="Introduzca Modelo">

                    <label class="form-label mt-4"><i class="fa-solid fa-building" style="color: #913080;"></i> Seleccione un Departamento</label>
                    <select required class="form-select Select2" name="departamento" id="departamento">

                        <?php foreach ($datos['departamentos'] as $departamento) { ?>
                            <option value="<?php echo $departamento['id_departamento']; ?>"> <?php echo $departamento['nombre_departamento'] ?> </option>
                        <?php } ?>

                    </select>

                    <div class="form-group">
                        <label class="form-label mt-4"> 
                            <i class="fa-solid fa-align-left" style="color: #63E6BE;"></i>
                            Describa las caracteristicas de este dispositivo (adicionalmente describir caracteristicas como color para que sea mas facil su identificacion) 
                        </label>
                            <textarea type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Describa" rows="3"></textarea>
                            <div id="mensajeValidacion" class="form-text"></div>
                    </div>

                    <br>
                    
                    <button class="btn btn-success" type="submit" id="btnSubmit">
                        Registrar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    const mensajeValidacion = document.getElementById('mensajeValidacion');
    const inputTexto = document.getElementById('descripcion');
    const btnSubmit = document.getElementById('btnSubmit');

    // Agrega un evento de entrada al textarea para validar en tiempo real
    inputTexto.addEventListener('input', function () {
        // Obtiene el valor del textarea y cuenta la longitud
        const valor = descripcion.value.trim();
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

<?php require_once "Views/footers/footer.php"; ?>