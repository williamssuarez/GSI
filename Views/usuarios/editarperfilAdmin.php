

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?></h1>
 <p class="mb-4">Ingrese los nuevos datos del  usuario en el formulario</p>

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">

            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Actualizar Usuario</h1>
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
                                            title="Solo se permiten letras y espacios" 
                                            value="<?php echo $data['operador']['nombres'] ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-person"></i> 
                                            Primer y Segundo Apellido del Operador
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="apellidos" id="apellidos" 
                                            placeholder="Introduzca Apellido" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios"
                                            value="<?php echo $data['operador']['apellidos'] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-id-card" style="color: #e7820d;"></i> 
                                            Cedula de identidad del Operador                                     
                                        </label>
                                        <input type="number" class="form-control form-control-user" minlength="7" maxlength="9" 
                                            name="cedula" id="cedula" placeholder="Introduzca Cedula" required
                                            value="<?php echo $data['operador']['cedula'] ?>">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <i class="fa-solid fa-user-plus"></i>
                                    Actualizar Usuario
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            
    </div>
</div>
