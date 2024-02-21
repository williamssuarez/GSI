

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?></h1>
 <p class="mb-4">Una tabla para los tipos de dispositivos</p>

<h1 class="h3 mb-2 text-gray-800">Tabla</h1>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Categorias <i class="fa-solid fa-table"></i></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover responsive nowrap" id="tabla_departamentos" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Categoria <i class="fa-solid fa-signature" style="color: #005cfa;"></i></th>
                                <th>Nombre <i class="fa-solid fa-align-left" style="color: #63E6BE;"></i></th>
                                <th>Descripcion <i class="fa-solid fa-align-left" style="color: #63E6BE;"></i></th>
                                <th>Fecha Creada <i class="fa-solid fa-calendar-days"></i></th>
                                <th>Creado Por <i class="fa-solid fa-person" style="color: #00040a;"></i></th>
                                <th>Acciones <i class="fa-solid fa-gears"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach($data['tipo_dispositivos'] as $data){ ?>
                            <tr class="table">
                                <td> <?php echo $data['categoria'] ?> </td>
                                <td> <?php echo $data['nombre_tipo'] ?> </td>
                                <td> <?php echo $data['descripcion'] ?> </td>
                                <td> <?php echo $data['fecha_creado'] ?> </td>
                                <td> <?php echo $data['nombres'] ?> </td>
                                <td>                         
                                    <a class="btn btn-primary" href='edit/<?php echo $data['id_tipo'] ?>'>                                        
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
<?php require_once "Views/footers/footer.php"; ?>