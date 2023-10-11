

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?> </h1>
 <p class="mb-4">Ingrese los datos del nuevo usuario en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Usuarios <i class="fa-solid fa-users"></i></h6>
    </div>
    <div class="card-body">
        <div>

        <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
            
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h1 text-primary mb-4">Datos del Usuario</h1>
                                    </div>
                                    <hr>
                                        <h1 class="h5 text-gray-900 mb-4">
                                            <i class="fa-solid fa-user-tag" style="color: #003694;"></i>
                                            Nombres: <?php echo $data['user']['nombres'] ?>  
                                        </h1>
                                        <h1 class="h5 text-gray-900 mb-4">
                                            <i class="fa-solid fa-user-tag" style="color: #003694;"></i> 
                                            Apellidos: <?php echo $data['user']['apellidos'] ?>  
                                        </h1>
                                        <h1 class="h5 text-gray-900 mb-4">
                                            <i class="fa-solid fa-id-card" style="color: #e7820d;"></i>
                                            Cedula: <?php echo $data['user']['cedula'] ?>  
                                        </h1>
                                        <h1 class="h5 text-gray-900 mb-4">
                                            <i class="fa-solid fa-envelope" style="color: #0043b8;"></i>
                                            Correo: <?php echo $data['user']['correo'] ?>  
                                        </h1>
                                        <h1 class="h5 text-gray-900 mb-4">
                                            <i class="fa-solid fa-mobile-screen-button" style="color: #6e6e6e;"></i>
                                            Telefono: <?php echo $data['user']['telefono'] ?>  
                                        </h1>
                                        <h1 class="h5 text-gray-900 mb-4">
                                            <i class="fa-solid fa-person" style="color: #00040a;"></i> 
                                            Usuario: <?php echo $data['user']['usuario'] ?> 
                                        </h1>
                                        <h1 class="h5 text-gray-900 mb-4">
                                             
                                            Fecha Agregado: <?php echo $data['user']['fecha_agregado'] ?> 
                                        </h1>
                                        <h1 class="h5 text-gray-900 mb-4">
                                            
                                            Estado:
                                                <?php if($data['user']['estado'] == 0){ ?> 
                                                    Activo
                                                <?php } else { ?>
                                                    Inactivo
                                                <?php }  ?>
                                        </h1>
                                        <h1 class="h5 text-gray-900 mb-4">
                                            <i class="fa-solid fa-key" style="color: #04225d;"></i> 
                                            Rol:
                                            <?php if($data['user']['rol'] == 1){ ?> 
                                                    Administrador
                                            <?php } else { ?>
                                                    Operador
                                            <?php }  ?>
                                        </h1>
                                        <hr>
                                        <div class="btn-group btn-user btn-block">

                                            <?php if($_SESSION['rol'] == 1){ ?>

                                                <a href="<?php echo URL; ?>usuarios/index" class="btn btn-primary" aria-current="page">
                                                    Volver
                                                </a>

                                            <?php } else {  ?>

                                                <a href="<?php echo URL; ?>inicio/index" class="btn btn-primary" aria-current="page">
                                                    Volver
                                                </a>

                                            <?php } ?>

                                            <?php if($_SESSION['rol'] == 1){ ?>

                                                <a href="<?php echo URL; ?>usuarios/editarperfilAdmin/<?php echo $_SESSION['usuario'] ?>" class="btn btn-warning" aria-current="page">
                                                    Editar Perfil
                                                </a>

                                            <?php } ?>

                                            <?php if($_SESSION['rol'] == 1){ ?>

                                                <a id="editarcredenciales" href="<?php echo URL; ?>usuarios/cambiarcredencialesAdmin/<?php echo $_SESSION['usuario'] ?>" class="btn btn-secondary" aria-current="page">
                                                    Editar Credenciales
                                                </a>

                                            <?php } else {  ?>

                                                <a id="editarcredenciales" href="<?php echo URL; ?>usuarios/cambiarcredencialesOperador/<?php echo $_SESSION['usuario'] ?>" class="btn btn-secondary" aria-current="page">
                                                    Editar Credenciales
                                                </a>
                                            <?php } ?>

                                            <?php if($_SESSION['usuario'] == $data['user']['usuario']) { ?>

                                                <a id="editarpreguntasseguridad" href="<?php echo URL; ?>usuarios/editarpreguntasSeguridad/<?php echo $_SESSION['usuario'] ?>" class="btn btn-info" aria-current="page">
                                                    Editar Preguntas de seguridad
                                                </a>

                                            <?php } ?>

                                            <?php if($_SESSION['rol'] == 1) { ?>

                                                <?php if( $data['user']['usuario'] != $_SESSION['usuario'] ){  ?>

                                                    <?php if($data['user']['estado'] == 0) { ?>

                                                    <a id="desactivar" href="<?php echo URL; ?>usuarios/desactivarusuario/<?php echo $data['user']['usuario'] ?>" class="btn btn-danger" aria-current="page">
                                                        Desactivar Operador
                                                    </a>

                                                    <?php } else { ?>

                                                    <a id="reactivar" href="<?php echo URL; ?>usuarios/reactivarusuario/<?php echo $data['user']['usuario'] ?>" class="btn btn-success" aria-current="page">
                                                        Reactivar Operador
                                                    </a>

                                                    <?php } ?>

                                                <?php } ?>

                                            <?php } ?>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

        </div>
    </div>
</div>
