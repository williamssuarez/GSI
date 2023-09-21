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

            <form action="new" method="post">


            <div>
                <label class="form-label mt-4"><i class="fa-solid fa-tag" style="color: #279608;"></i> Numero de Bien</label>
                <input required class="form-control" type="number" name="numero_bien" id="numero_bien" maxlength="6" minlength="6" placeholder="Introduzca Numero de Bien">
                
                <label class="form-label mt-4"><i class="fa-solid fa-building" style="color: #913080;"></i> Departamento</label>
                <select required class="form-select" name="departamento" id="departamento">

                    <?php foreach ($datos['departamentos'] as $departamento) { ?>
                        <option value="<?php echo $departamento['id_departamento']; ?>"> <?php echo $departamento['nombre_departamento'] ?> </option>
                    <?php } ?>

                </select>                

                <label class="form-label mt-4"><i class="fa-solid fa-calendar-days"></i> Fecha Recibido</label>
                <input class="form-control" required type="datetime-local" name="fecha_recibido" id="fecha_recibido" value="" max="" min="2020-01-01T00:00"> 

                

                <label class="form-label mt-4"><i class="fa-solid fa-user-gear" style="color: #005af5;"></i> Recibido Por</label>
                <select required class="form-select" name="recibido_por" id="recibido_por">
                        
                        <?php foreach($datos['operadores'] as $operadores) {  ?>
                            <option value="<?php echo $operadores['id_operador']; ?>"> <?php echo $operadores['nombre'] ?> </option>
                        <?php } ?>

                </select>

                <label class="form-label mt-4"><i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i> Problema</label>
                <input required class="form-control" type="text" name="problema" id="problema" placeholder="Cual es el problema del equipo">
                
                <br>
            
                <button class="btn btn-success" type="submit">
                    <i class="fa-solid fa-circle-arrow-down"></i>
                    Ingresar
                </button>

            </div>

            </form>

        </div>
    </div>
</div>


<script src="<?php echo URL; ?>Views/template/js/scripts/getFechaActual.js" ></script>


