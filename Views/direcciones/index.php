<?php $datos = $direcciones->index(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?></h1>
 <p class="mb-4">Una tabla para las direcciones</p>

<h1 class="h3 mb-2 text-gray-800">Tabla</h1>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Direcciones <i class="fa-solid fa-globe"></i></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover responsive nowrap" id="tabla_direcciones" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Direccion IP <i class="fa-solid fa-ethernet"></i></th>
                                <th>Departamento <i class="fa-solid fa-network-wired"></i></th>
                                <th>Dispositivo </th>
                                <th>Numero de Bien </th>
                                <th>Fecha Asignada </th>
                                <th>Acciones <i class="fa-solid fa-gears"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach($datos['direcciones'] as $data){ ?>
                            <tr class="table">
                                <td> <?php echo $data['direccion'] ?> </td>
                                <td> <?php echo $data['departamento'] ?> </td>
                                <td> <?php echo $data['dispositivo'] ?> </td>
                                <td> 
                                    <?php if(!empty($data['equipo'])){  ?>

                                        <a href="<?php echo URL ;?>equipos/viewequipo/<?php echo $data['equipo'] ?>" style="text-decoration:none"> 
                                            <?php echo $data['numero_bien'] ?> 
                                        </a>

                                    <?php } else { ?>

                                        <?php echo $data['numero_bien'] ?>
                                        
                                    <?php } ?>
                                </td>
                                <td> <?php echo $data['fecha_asignada'] ?> </td>
                                <td>                         
                                    <a id="liberardireccionIP" class="btn btn-danger btn-icon-split" href='liberarDireccion/<?php echo $data['id_asignacion'] ?>'>                                
                                        Liberar
                                    </a>               
                                </td>
                            </tr>
                        <?php } ?>    
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <a class="btn btn-success btn-icon-split" href="rango">
                <i class="fa-solid fa-ethernet"></i>
                Asignar
            </a>
        </div>
<?php require_once "Views/footers/footer.php"; ?>