<?php $datos = $usuarios->index(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?></h1>
 <p class="mb-4">Una tabla para los usuarios del sistema</p>

<h1 class="h3 mb-2 text-gray-800">Tabla</h1>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Usuarios <i class="fa-solid fa-users"></i></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover responsive nowrap" id="tabla_departamentos" width="100%" cellspacing="0">
                        <thead>
                            <tr>                                
                                <th>ID User <i class="fa-solid fa-person" style="color: #bb840c;"></i></th>
                                <th>Nombres <i class="fa-solid fa-user-tag" style="color: #003694;"></i></th>
                                <th>Apellidos <i class="fa-solid fa-user-tag" style="color: #003694;"></i> </th>
                                <th>Cedula <i class="fa-solid fa-id-card" style="color: #e7820d;"></i></th>
                                <th>Rol <i class="fa-solid fa-key" style="color: #04225d;"></i></th>
                                <th>Estado</th>
                                <th>Acciones <i class="fa-solid fa-gears"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach($datos['usuarios'] as $data){ ?>
                            <tr class="table">
                                <td> <?php echo $data['id_user'] ?> </td>
                                <td> <?php echo $data['nombres'] ?> </td>
                                <td> <?php echo $data['apellidos'] ?> </td>
                                <td> <?php echo $data['cedula'] ?> </td>
                                <td>
                                    <?php
                                    if ($data['rol'] == 1) { ?>

                                        <span class=" font-weight-bold" >
                                            Administrador
                                        </span>

                                    <?php } else { ?>

                                        <span class=" font-weight-bold" >
                                            Operador
                                        </span>

                                    <?php }  ?>
                                </td>
                                <td>
                                    <?php
                                    if ($data['estado'] == 1) { ?>

                                        <span class=" font-weight-bold" >
                                            Inactivo  <i class="fa-solid fa-circle-exclamation" style="color: #d4ac40;"></i>
                                        </span>

                                    <?php } else { ?>

                                        <span class=" font-weight-bold" >
                                            Activo <i class="fa-solid fa-circle-check" style="color: #3aa413;"></i>
                                        </span>

                                    <?php }  ?>
                                </td>
                                    <td>                         
                                        <a class="btn btn-primary" href='edit/<?php echo $data['id_user'] ?>'>                                        
                                            Editar
                                        </a>
                                        <a class="btn btn-danger" href='delete/<?php echo $data['id_user'] ?>'>                                        
                                            Eliminar
                                        </a>                    
                                    </td>
                                </tr>
                            <?php } ?>    

                        </tbody>
                    </table>
                </div>
            </div>
            <a class="btn btn-success btn-icon-split" href="newuser">
                Agregar
            </a>
        </div>
