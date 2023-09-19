<?php $datos = $direcciones->index(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?></h1>
 <p class="mb-4">Una tabla para las direcciones</p>

<h1 class="h3 mb-2 text-gray-800">Tabla</h1>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Direcciones</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover responsive nowrap" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Direccion IP</th>
                                <th>Departamento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach($datos['direcciones'] as $data){ ?>
                            <tr class="table">
                                <td> <?php echo $data['direccion'] ?> </td>
                                <td> <?php echo $data['departamento'] ?> </td>
                                <td>                            
                                    <a class="btn btn-danger" href='delete/<?php echo $data['id_ip'] ?>'>Eliminar</a> 
                                    <a class="btn btn-primary" href='edit/<?php echo $data['id_ip'] ?>'>Editar</a>                    
                                </td>
                            </tr>
                        <?php } ?>    
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <a class="btn btn-success" href="new">Agregar</a>
        </div>

    


<script>

$(document).ready(function () {
            $('#dataTable').DataTable(); 
            })


</script>