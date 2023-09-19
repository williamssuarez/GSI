<?php $datos = $direcciones->getDireccionesLibres() ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> new!</h1>
 <p class="mb-4">Defina la direccion IP que le gustaria asignar al departamento</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
       <h6 class="m-0 font-weight-bold text-primary">Direccion</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

        <form action="new" method="post">
            <div>
                <label class="form-label mt-4">Departamento</label>
                <select required class="form-select" name="departamento" id="departamento">

                    <?php foreach ($datos['departamentos'] as $departamento) { ?>
                        <option value="<?php echo $departamento['id_departamento']; ?>"> <?php echo $departamento['nombre_departamento'] ?> </option>
                    <?php } ?>

                </select>

                <br>
                
                <label class="form-label mt-4">Direccion</label>
                <select required class="form-select" name="direccion" id="direccion">
                        
                        <?php foreach($datos['direcciones'] as $direcciones) {  ?>
                            <option value="<?php echo $direcciones['id']; ?>"> <?php echo $direcciones['direccion'] ?> </option>
                        <?php } ?>

                </select>
                
                        </br>

                <button class="btn btn-success" type="submit">Asignar</button>
            </div>

        </form>

        </div>
    </div>
</div>