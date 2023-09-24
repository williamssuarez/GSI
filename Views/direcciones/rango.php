<?php $datos = $direcciones->rango();

?>

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

        <form action="rango" method="post">
            <div>

                <label class="form-label mt-4">Direccion</label>
                <select required class="form-select" name="departamento" id="departamento">
                        
                        <?php foreach($datos['departamentos'] as $direcciones) {  ?>
                            <option value="<?php echo $direcciones['id_departamento']; ?>"> <?php echo $direcciones['nombre_departamento'] ?> </option>
                        <?php } ?>

                </select>

                <button class="btn btn-success" type="submit">Obtener Rango</button>
            </div>

        </form>

        </div>
    </div>
</div>