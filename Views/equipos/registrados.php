<?php $equipo = $equipos->registrados(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $equipo['titulo']; ?></h1>
 <p class="mb-4">Una tabla para administrar a los equipos entregados</p>

         <h1 class="h3 mb-2 text-gray-800">Tabla</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Equipos Entregados <i class="fa-solid fa-truck-fast"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover responsive nowrap" id="tablaequipos_salida" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Numero de Bien <i class="fa-solid fa-tag" style="color: #279608;"></i></th>
                        <th>Departamento <i class="fa-solid fa-building" style="color: #913080;"></i></th>
                        <th>Usuario <i class="fa-solid fa-person" style="color: #00040a;"></i></th>
                        <th>Direccion MAC <i class="fa-solid fa-receipt" style="color: #545454;"></i></th>
                        <th>Direccion IP <i class="fa-solid fa-globe" style="color: #1049ad;"></i></th>
                        <th>Fecha Registro <i class="fa-solid fa-calendar-days"></i></th>
                        <th>Ingresos  <i class="fa-solid fa-clipboard-check" style="color: #1c931a;"></i></th>
                        <th>Acciones <i class="fa-solid fa-gears"></i></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($equipo['equipos'] as $data){ ?>
                        <tr>            
                            <td><a href="viewequipo/<?php echo $data['id_equipo'] ?>" style="text-decoration:none"> <?php echo $data['numero_bien'] ?> </a></td>
                            <td> <?php echo $data['departamento'] ?> </td>
                            <td> <?php echo $data['usuario'] ?> </td>
                            <td> <?php echo $data['direccion_mac'] ?> </td>
                            <td> <?php echo $data['direccion_ip'] ?> </td>
                            <td> <?php echo $data['fecha_registro'] ?> </td>
                            <td> <?php echo $data['ingresos'] ?> </td>
                            <td>
                                <a class="btn btn-info" href='editregistro/<?php echo $data['id_equipo'] ?>'>Editar</a>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
    <a class="btn btn-success" href="newregistro">
        <i class="fa-solid fa-arrow-right"></i>
        Registrar
    </a>