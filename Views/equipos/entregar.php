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

                <label class="form-label mt-4"><i class="fa-solid fa-clipboard-check" style="color: #1c931a;"></i> Conclusion</label>
                <br>
                <label for=""><i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i> Problema por el que ingreso el equipo: <?php echo $data['problem']['problema'] ?></label>
                <div class="form-floating">
                    <input required class="form-control" type="text" name="conclusion" id="conclusion" placeholder="Cual fue la solucion que se le dio al equipo">                    
                    <label for="conclusion">Cual fue la solucion que se le dio al equipo</label>
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