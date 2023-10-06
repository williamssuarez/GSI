

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?> </h1>
 <p class="mb-4">Ingrese los datos del nuevo usuario en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Usuarios <i class="fa-solid fa-users"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

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
                                            <i class="fa-solid fa-person" style="color: #00040a;"></i> 
                                            Usuario: <?php echo $data['user']['usuario'] ?> 
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
                                            Rol: <?php echo $data['user']['rol'] ?>  
                                        </h1>
                                        <div class="btn-group btn-user btn-block">
                                            <a href="<?php echo URL; ?>equipos/registrados" class="btn btn-primary" aria-current="page">Volver</a>
                                            
                                        </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>

        </div>
    </div>
</div>
