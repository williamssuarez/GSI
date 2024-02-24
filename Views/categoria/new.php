<?php $datos = $categoria->index() ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> new!</h1>
 <p class="mb-4">Ingrese los datos de la nueva categoria en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Categoria <i class="fa-solid fa-table"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="new" method="post">

                <div>

                    <label class="form-label mt-4">
                        <i class="fa-solid fa-signature" style="color: #005cfa;"></i> 
                        Inserte el nombre de la categoria 
                    </label>
                    <input required class="form-control" type="text" name="nombre_categoria" id="nombre_categoria" placeholder="Introduzca Nombre">

                    <div class="form-group">
                        <label class="form-label mt-4"> 
                            <i class="fa-solid fa-align-left" style="color: #63E6BE;"></i>
                            Describa esta categoria y lo que engloba 
                        </label>
                            <textarea required type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Describa" rows="3"></textarea>
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