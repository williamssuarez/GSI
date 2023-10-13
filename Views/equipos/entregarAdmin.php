<?php $datos = $equipos->getDataSalida(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['title']; ?> Entrega!</h1>
 <p class="mb-4">Ingrese los datos del equipo a entregar en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>

<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" >Entregar Equipo <i class="fa-solid fa-truck-fast"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="" method="post">


            <div>
                
            
                <label class="form-label mt-4"><i class="fa-solid fa-calendar-days"></i> Fecha Entrega</label>
                <input required class="form-control" type="datetime-local" name="fecha_entrega" id="fecha_entrega" value="" max="" min="2020-01-01T00:00">

                <label class="form-label mt-4"><i class="fa-solid fa-user-gear" style="color: #005af5;"></i> Entregado Por</label>
                <select required class="form-select" name="entregado_por" id="entregado_por">
    
                <?php foreach($datos['operadores'] as $operadores) {  ?>
                    <option value="<?php echo $operadores['id_operador']; ?>"> <?php echo $operadores['nombre'] ?>  <?php echo $operadores['apellido'] ?></option>
                <?php } ?>

                </select>

                <div class="form-group">
                    <label class="form-label mt-4"><i class="fa-solid fa-clipboard-check" style="color: #1c931a;"></i> Conclusion</label>
                        <textarea required class="form-control" type="text" name="conclusion" id="conclusion" placeholder="Cual fue la solucion que se le dio al equipo" rows="3"></textarea>
                        <div id="mensajeValidacion2" class="form-text"></div>
                </div>
                

                <br>
            
                <button class="btn btn-success" type="submit">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                    Entregar
                </button>

            </div>

            </form>

        </div>
    </div>
</div>


<script src="<?php echo URL; ?>Views/template/js/scripts/getFechaActualEntrega.js" ></script>
<script>

    // Obtén el elemento del textarea y el botón submit
    const inputTexto = document.getElementById('conclusion');
    const btnSubmit = document.getElementById('btnSubmit2');
    const mensajeValidacion = document.getElementById('mensajeValidacion2');

    // Agrega un evento de entrada al textarea para validar en tiempo real
    inputTexto.addEventListener('input', function () {
        // Obtiene el valor del textarea y cuenta la longitud
        const valor = conclusion.value.trim();
        const longitud = valor.length;
        
        // Validación: no más de 200 caracteres
        if (longitud <= 200) {
            // Cambia el estilo y habilita el botón submit
            inputTexto.classList.remove('is-invalid');
            inputTexto.classList.add('is-valid');
            mensajeValidacion.textContent = '';
            btnSubmit.disabled = false;
        } else if(longitud == 0){

            // Cambia el estilo y deshabilita el botón submit
            inputTexto.classList.remove('is-valid');
            inputTexto.classList.add('is-invalid');
            mensajeValidacion.textContent = 'El texto no puede estar vacio.';
            btnSubmit.disabled = true;

        } else {
            // Cambia el estilo y deshabilita el botón submit
            inputTexto.classList.remove('is-valid');
            inputTexto.classList.add('is-invalid');
            mensajeValidacion.textContent = 'El texto no debe exceder los 200 caracteres.';
            btnSubmit.disabled = true;
        }
    });


</script>