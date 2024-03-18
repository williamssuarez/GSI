<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?></h1>
<p class="mb-4">Una tabla para los empleados no operadores de la institucion</p>

<h1 class="h3 mb-2 text-gray-800">Tabla</h1>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Empleados <i class="fa-solid fa-print"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover responsive nowrap" id="tabla_empleados" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Nombre Completo <i class="fa-solid fa-stairs" style="color: #005cfa;"></i></th>
                    <th>Cedula <i class="fa-solid fa-gears"></i></th>
                    <th>Departamento <i class="fa-solid fa-gears"></i></th>
                    <th>Fecha Registro<i class="fa-solid fa-gears"></i></th>
                    <th>Acciones <i clsass="fa-solid fa-gears"></i></th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($data['empleados'] as $data){ ?>
                    <tr class="table">
                        <td> <?php echo $data['nombre_completo'] ?> </td>
                        <td> <?php echo $data['cedula'] ?> </td>
                        <td> <?php echo $data['departamento'] ?> </td>
                        <td> <?php echo $data['fecha_registro'] ?> </td>
                        <td>
                            <a class="btn btn-primary" href='edit/<?php echo $data['id_empleado'] ?>'>
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
