<?php $datos = $operadores->index(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?></h1>
 <p class="mb-4">Una tabla para administrar a los operadores</p>

         <h1 class="h3 mb-2 text-gray-800">Tabla</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Operadores <i class="fa-solid fa-users-gear"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover nowrap" id="tablaoperadores" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre <i class="fa-solid fa-user-gear" style="color: #005af5;"></i></th>
                        <th>Apellido <i class="fa-solid fa-person"></i></th>
                        <th>Cedula <i class="fa-solid fa-id-card" style="color: #e7820d;"></i></th>
                        <th>Correo <i class="fa-solid fa-envelope" style="color: #0ab6cd;"></i></th>                        
                        <th>Equipos Entregados <i class="fa-solid fa-people-carry-box" style="color: #48b71f;"></i></th>
                        <th>Equipos Ingresados <i class="fa-solid fa-display" style="color: #d21414;"></i></th>                        
                        <th>Estado <i class="fa-solid fa-user-tag" style="color: #347f8d;"></i></th>
                        <th>Acciones <i class="fa-solid fa-gears"></i></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($datos['operadores'] as $data){ ?>
                        <tr>
                            <td> <?php echo $data['nombre'] ?> </td>
                            <td> <?php echo $data['apellido'] ?> </td>
                            <td> <?php echo $data['cedula_identidad'] ?> </td>
                            <td> <?php echo $data['correo'] ?> </td>                            
                            <td> <?php echo $data['equipos_entregados'] ?> </td>
                            <td> <?php echo $data['equipos_ingresados'] ?> </td>
                            <td><?php 
                                if($data['estado'] == 0){
                                    echo "Activo";
                                }
                                else {
                                    echo "Inactivo";
                                }
                                 ?> 
                            </td>
                            <td>      
                                
                                <?php if($data['estado'] == 0){ ?>

                                    <a id="suspendiendo" class="btn btn-warning btn-icon-split" href='suspend/<?php echo $data['id_operador'] ?>'>
                                        <i class="fa-solid fa-user-large-slash"></i>
                                        Suspender
                                    </a>

                                <?php } else {  ?>

                                    <a id="reactivando" class="btn btn-success btn-icon-split" href='activate/<?php echo $data['id_operador'] ?>'>
                                        <i class="fa-solid fa-user-check"></i>
                                        Reactivar
                                    </a>

                                <?php } ?>
                                
                                <a class="btn btn-primary btn-icon-split" href='edit/<?php echo $data['id_operador'] ?>'>
                                    <i class="fa-solid fa-user-pen"></i>
                                    Editar
                                </a>
                                

                                <a id="eliminando" class="btn btn-danger btn-icon-split" href='delete/<?php echo $data['id_operador'] ?>'>
                                    <i class="fa-solid fa-user-minus"></i>
                                    Eliminar
                                </a> 
                                                    
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>

    <a class="btn btn-success" href="new">
        <i class="fa-solid fa-user-plus"></i>
        Agregar
    </a>