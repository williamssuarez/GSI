<?php $datos = $usuarios->index() ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> new!</h1>
 <p class="mb-4">Ingrese los datos del nuevo usuario en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Usuarios <i class="fa-solid fa-users"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="newuser" method="post">


                <div>
                    <label class="form-label mt-4"><i class="fa-solid fa-user-gear" style="color: #005af5;"></i> Primer y Segundo Nombre del Operador </label>
                    <input required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios" class="form-control" type="text" name="nombres" id="nombres" placeholder="Introduzca Nombres">
                    
                    <label class="form-label mt-4"><i class="fa-solid fa-person"></i> Primer y Segundo Apellido del Operador</label>
                    <input required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios" class="form-control" type="text" name="apellidos" id="apellidos" placeholder="Introduzca Apellido">

                    <label class="form-label mt-4"><i class="fa-solid fa-id-card" style="color: #e7820d;"></i> Cedula de identidad del Operador</label>
                    <input required class="form-control" type="number" minlength="7" maxlength="9" name="cedula" id="cedula" placeholder="Introduzca Cedula"> 

                    <label class="form-label mt-4"><i class="fa-solid fa-envelope" style="color: #0ab6cd;"></i> Usuario</label>
                    <input required class="form-control" type="text" name="usuario" id="usuario" placeholder="Introduzca Usuario">

                    <label class="form-label mt-4"><i class="fa-solid fa-lock" style="color: #c90d0d;"></i> Clave inicial</label>
                    <input required class="form-control" type="text" name="clave" id="clave" placeholder="Introduzca Clave">

                    <label class="form-label mt-4"><i class="fa-solid fa-lock" style="color: #c90d0d;"></i> Confirmar Clave inicial</label>
                    <input required class="form-control" type="text" name="clave_confirmacion" id="clave_confirmacion" placeholder="Introduzca Clave">

                    <label class="form-label mt-4"><i class="fa-solid fa-key" style="color: #04225d;"></i> Rol del sistema</label>
                    <select required class="form-select" name="rol" id="rol">
                        <option value="2">Operador</option>
                        <option value="1">Administrador</option>
                    </select>

                    <br>
                    
                    <button class="btn btn-success" type="submit">
                        <i class="fa-solid fa-user-plus"></i>
                        Registrar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="<?php echo URL; ?>Views/template/js/scripts/validarFormOperadores.js"></script>