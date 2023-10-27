<?php $datos = $usuarios->index() ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?></h1>
 <p class="mb-4">Ingrese los datos del nuevo usuario en el formulario</p>

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register">
                    <img class="gsi-preguntas-imagen" src="<?php echo URL; ?>Views/template/img/perfil.png" alt="">
                </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Nuevo Usuario</h1>
                        </div>
                            <form class="user" method="post" action="">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-user-gear" style="color: #005af5;"></i> 
                                            Primer y Segundo Nombre del Operador                                     
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="nombres" id="nombres"
                                            placeholder="Introduzca Nombres"  required pattern="[A-Za-z\s]+" 
                                            title="Solo se permiten letras y espacios">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-person"></i> 
                                            Primer y Segundo Apellido del Operador
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="apellidos" id="apellidos" 
                                        placeholder="Introduzca Apellido" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-id-card" style="color: #e7820d;"></i> 
                                            Cedula de identidad del Operador                                     
                                        </label>
                                        <input type="number" class="form-control form-control-user" minlength="7" maxlength="9" 
                                        name="cedula" id="cedula" placeholder="Introduzca Cedula"  required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-user" style="color: #001c4d;"></i> 
                                            Usuario
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="usuario" id="usuario" 
                                        placeholder="Introduzca Usuario" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-envelope" style="color: #0043b8;"></i> 
                                            Correo del Operador                                     
                                        </label>
                                        <input type="text" class="form-control form-control-user" 
                                        name="correo" id="correo" placeholder="Introduzca Correo"  required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-mobile-screen-button" style="color: #6e6e6e;"></i> 
                                            Telefono del Operador
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="telefono" id="telefono" 
                                        placeholder="Introduzca Telefono" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #c90d0d;"></i> 
                                            Clave inicial
                                        </label>
                                        <input type="password" class="form-control form-control-user"
                                        name="clave" id="clave" placeholder="Introduzca Clave" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #c90d0d;"></i> 
                                            Confirmar Clave inicial
                                        </label>
                                        <input type="password" class="form-control form-control-user"
                                        name="clave_confirmacion" id="clave_confirmacion" placeholder="Introduzca Clave">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mt-4"><i class="fa-solid fa-key" style="color: #04225d;"></i> Rol del sistema</label>
                                    <select required class="form-select form-control-user" name="rol" id="rol">
                                        <option value="2">Operador</option>
                                        <option value="1">Administrador</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <i class="fa-solid fa-user-plus"></i>
                                    Registrar Usuario
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            
    </div>
</div>

<script src="<?php echo URL; ?>Views/template/js/scripts/validarFormOperadores.js"></script>