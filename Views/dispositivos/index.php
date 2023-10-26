

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?></h1>
 <p class="mb-4">Una tabla para las direcciones</p>

<h1 class="h3 mb-2 text-gray-800">Tabla</h1>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Dispositivos <i class="fa-solid fa-print"></i></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover responsive nowrap" id="tabla_departamentos" width="100%" cellspacing="0">
                        <thead>
                            <tr>                                
                                <th>Dispositivo <i class="fa-solid fa-stairs" style="color: #005cfa;"></i></th>
                                <th>Asignaciones <i class="fa-solid fa-gears"></i></th>
                                <th>Acciones <i class="fa-solid fa-gears"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach($data['dispositivos'] as $data){ ?>
                            <tr class="table">
                                <td> <?php echo $data['nombre_dispositivo'] ?> </td>
                                <td> <?php echo $data['total_asignaciones'] ?> </td>
                                <td>                         
                                    <a class="btn btn-primary" href='edit/<?php echo $data['id_dispositivos'] ?>'>                                        
                                        Editar
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
