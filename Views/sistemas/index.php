<?php $datos = $sistemas->index(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?></h1>
 <p class="mb-4">Una tabla para los sistemas operativos</p>

<h1 class="h3 mb-2 text-gray-800">Tabla</h1>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Sistemas Operativos <i class="fa-brands fa-ubuntu"></i></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover responsive nowrap" id="tabla_departamentos" width="100%" cellspacing="0">
                        <thead>
                            <tr>                                
                                <th>Nombre <i class="fa-solid fa-stairs" style="color: #005cfa;"></i></th>
                                <th>Tipo <i class="fa-brands fa-windows" style="color: #075ced;"></i></th>
                                <th>Fecha Agregado <i class="fa-solid fa-calendar"></i></th>
                                <th>Acciones <i class="fa-solid fa-gears"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach($datos['sistemas'] as $data){ ?>
                            <tr class="table">
                                <td> <?php echo $data['nombre'] ?> </td>
                                <td>
                                <?php
                                if ($data['tipo'] == 0) { ?>

                                    <span class=" font-weight-bold" >
                                        Windows <i class="fa-brands fa-windows" style="color: #105ada;"></i>
                                    </span>

                                <?php } else { ?>

                                    <span class=" font-weight-bold" >
                                        Linux <i class="fa-brands fa-linux" style="color: #e08910;"></i>
                                    </span>

                                <?php }  ?>
                            </td>
                                <td> <?php echo $data['fecha_agregado'] ?> </td>
                                <td>                         
                                    <a class="btn btn-primary" href='edit/<?php echo $data['id_os'] ?>'>                                        
                                        Editar
                                    </a>
                                    <a class="btn btn-danger" href='delete/<?php echo $data['id_os'] ?>'>                                        
                                        Eliminar
                                    </a>                    
                                </td>
                            </tr>
                        <?php } ?>    

                        </tbody>
                    </table>
                </div>
            </div>
            <a class="btn btn-success btn-icon-split" href="new">
                Agregar
            </a>
        </div>
