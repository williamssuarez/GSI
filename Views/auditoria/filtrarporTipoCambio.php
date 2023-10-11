
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['title']; ?> new!</h1>
 <p class="mb-4">Defina el usuario para el filtro</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>

         <br>
            <a href="<?php echo URL; ?>auditoria/index" class="btn btn-danger" type="submit">Cancelar</a>
         <br></br>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
       <h6 class="m-0 font-weight-bold text-primary">Filtro</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

        <form action="" method="post">
            <div>

                <label class="form-label mt-4">Usuarios</label>
                <select required class="form-select" name="cambio" id="cambio">
                        
                        <?php foreach($data['cambios'] as $cambios) {  ?>
                            <option value="<?php echo $cambios['id_cambio']; ?>"> <?php echo $cambios['cambio'] ?> </option>
                        <?php } ?>

                </select>

                <br></br>

                <button class="btn btn-primary" type="submit">Filtrar</button>
            </div>

        </form>

        </div>
    </div>
</div>