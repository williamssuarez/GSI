

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?></h1>
 <p class="mb-4">Una tabla para los distintos dispositivos</p>

<h1 class="h3 mb-2 text-gray-800">Tabla</h1>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Dispositivos <i class="fa-solid fa-table"></i></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover responsive nowrap" id="tabla_departamentos" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tipo <i class="fa-solid fa-server" style="color: #0543ad;"></i></th>
                                <th>Marca <i class="fa-solid fa-copyright"></i></th>
                                <th>Serial <i class="fa-solid fa-barcode"></i></th>
                                <th>Modelo <i class="fa-solid fa-database" style="color: #c00c0c;"></i></th>
                                <th>Departamento <i class="fa-solid fa-building" style="color: #913080;"></i></th>
                                <th>Caracteristicas <i class="fa-solid fa-list-ol" style="color: #1e7000;"></i></th>
                                <th>Fecha Creado <i class="fa-solid fa-calendar-days"></i></th>
                                <th>Creado Por <i class="fa-solid fa-person" style="color: #00040a;"></i></th>
                                <th>Acciones <i class="fa-solid fa-gears"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach($data['dispositivos'] as $data){ ?>
                            <tr class="table">
                                <td> <?php echo $data['tipo_dispositivo'] ?> </td>
                                <td> <?php echo $data['marca'] ?> </td>
                                <td> <?php echo $data['serial'] ?> </td>
                                <td> <?php echo $data['modelo'] ?> </td>
                                <td> <?php echo $data['departamento'] ?> </td>
                                <td> <?php echo $data['caracteristicas'] ?> </td>
                                <td> <?php echo $data['fecha_creado'] ?> </td>
                                <td> <?php echo $data['creado_por'] ?> </td>
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