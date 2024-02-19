
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $_SESSION['filtrofecha']['titulo']; ?></h1>
 <p class="mb-4">Una tabla para consultar la auditoria</p>

<h1 class="h3 mb-2 text-gray-800">Tabla</h1>

<br></br>
<a class="btn btn-danger" href="<?php echo URL; ?>/auditoria/salirFiltroFecha">
    Deshacer
</a>
<br></br>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Auditoria <i class="fa-brands fa-ubuntu"></i></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover responsive nowrap" id="tabla_auditoria" width="100%" cellspacing="0">
                        <thead>
                            <tr>                                
                                <th>Cambio </th>
                                <th>Tabla Afectada </th>
                                <th>Registro Afectado </th>
                                <th>Valor Antes </th>
                                <th>Valor Despues </th>
                                <th>Usuario </th>
                                <th>Fecha </th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach($_SESSION['filtrofecha']['auditoria'] as $data){ ?>
                            <tr class="table">
                                <td> <?php echo $data['tipo_cambio'] ?> </td>
                                <td> <?php echo $data['tabla_afectada'] ?> </td>
                                <td> <?php echo $data['registro_afectado'] ?> </td>
                                <td> <?php echo $data['valor_antes'] ?> </td>
                                <td> <?php echo $data['valor_despues'] ?> </td>
                                <td> <?php echo $data['usuario'] ?> </td>
                                <td> <?php echo $data['fecha'] ?> </td>
                            </tr>
                        <?php } ?>    

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php require_once "Views/footers/footer.php"; ?>
