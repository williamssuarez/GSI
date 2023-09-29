
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?> new!</h1>
 <p class="mb-4">Ingrese los datos a editar del sistema operativo en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Sistemas <i class="fa-brands fa-windows"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="<?php echo URL; ?>sistemas/edit/<?php echo $data['sistemas']['id_os'] ?>" method="post">


                <div>

                    <label class="form-label mt-4">Inserte el nombre del sistema operativo </label>
                    <input required value="<?php echo $data['sistemas']['nombre'] ?>" class="form-control" type="text" name="nombre" id="nombre" placeholder="Introduzca Nombre">

                    <br>

                    <label class="form-label mt-4">Tipo de dispositivo</label>
                    <select required class="form-select" name="tipo" id="tipo">
                        <option value="0" <?php echo ($data['sistemas']['tipo'] == 0) ? 'selected' : ''; ?>>Windows</option>
                        <option value="1" <?php echo ($data['sistemas']['tipo'] == 1) ? 'selected' : ''; ?>>Linux</option>
                    </select>

                    <br>
                    
                    <button class="btn btn-success" type="submit">
                        Editar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

