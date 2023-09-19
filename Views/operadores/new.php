<?php $datos = $operadores->index() ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> new!</h1>
 <p class="mb-4">Ingrese los datos del nuevo operador en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" >Operadores</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="new" method="post">


                <div>
                    <label class="form-label mt-4">Nombre del Operador</label>
                    <input required class="form-control" type="text" name="nombre" id="nombre" placeholder="Introduzca Nombre">
                    
                    <label class="form-label mt-4">Apellido del Operador</label>
                    <input required class="form-control" type="text" name="apellido" id="apellido" placeholder="Introduzca Apellido">

                    <label class="form-label mt-4">Cedula de identidad del Operador</label>
                    <input required class="form-control" type="number" max="100000000" name="cedula_identidad" id="cedula_identidad" placeholder="Introduzca Cedula"> 

                    <label class="form-label mt-4">Correo del Operador</label>
                    <input required class="form-control" type="text" name="correo" id="correo" placeholder="Introduzca Correo">

                    <br>
                    
                    <button class="btn btn-success" type="submit">Registrar</button>
                </div>

            </form>

        </div>
    </div>
</div>
