<?php $datos = $equipos->getDataSalida(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> Entrega!</h1>
 <p class="mb-4">Ingrese los datos del equipo a entregar en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>

<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" >Entregar Equipo</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="" method="post">


            <div>
                
                <label class="form-label mt-4">Fecha Entrega</label>
                <input required class="form-control" type="datetime-local" name="fecha_entrega" id="fecha_entrega" value="" max="" min="2020-01-01T00:00">

                

                <label class="form-label mt-4">Entregado Por</label>
                <select required class="form-select" name="entregado_por" id="entregado_por">
                
                <?php foreach($datos['operadores'] as $operadores) {  ?>
                    <option value="<?php echo $operadores['id_operador']; ?>"> <?php echo $operadores['nombre'] ?>  <?php echo $operadores['apellido'] ?></option>
                <?php } ?>

                </select>                

                <label class="form-label mt-4">Conclusion</label>
                <input required class="form-control" type="text" name="conclusion" id="conclusion" placeholder="Cual fue la solucion que se le dio al equipo">

                <br>
            
                <button class="btn btn-success" type="submit">Entregar</button>

            </div>

            </form>

        </div>
    </div>
</div>


<script src="<?php echo URL; ?>Views/template/js/scripts/getFechaActualEntrega.js" ></script>