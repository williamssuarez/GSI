
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?> edit!</h1>
<p class="mb-4">Ingrese los datos del departamento a editar en el formulario</p>

        <h1 class="h3 mb-2 text-gray-800">Formulario</h1>        
        
<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Dispositivo <i class="fa-solid fa-print"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="<?php echo URL; ?>departamentos/edit/<?php echo $data['departamento']['id_departamento'] ?>" method="post">

                <div>

                    <label class="form-label mt-4">
                        <i class="fa-solid fa-building" style="color: #913080;"></i>
                        Inserte el nombre del departamento 
                    </label>
                    <input value="<?php echo $data['departamento']['nombre_departamento'] ?>" required class="form-control" type="text" name="nombre_departamento" id="nombre_departamento" placeholder="Introduzca Nombre">

                    <label class="form-label mt-4">
                        <i class="fa-solid fa-stairs" style="color: #005cfa;"></i>
                        Piso (Puede poner un numero como "5" o un texto como "Planta Baja")
                    </label>
                    <input value="<?php echo $data['departamento']['piso'] ?>" required class="form-control" type="text" name="piso" id="piso" placeholder="Introduzca Piso">

                    <div class="form-group">
                        <label class="form-label mt-4"> 
                            <i class="fa-solid fa-align-left" style="color: #63E6BE;"></i>
                            Describa o agregue mas informacion sobre este departamento
                        </label>
                        <textarea required value="<?php echo $data['departamento']['descripcion'] ?>" type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Describa" rows="3"><?php echo $data['departamento']['descripcion'] ?></textarea>
                            <div id="mensajeValidacion" class="form-text"></div>
                    </div>

                    <br>

                    <button class="btn btn-success" type="submit" id="btnSubmit">
                        Editar
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