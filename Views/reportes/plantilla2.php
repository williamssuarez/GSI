<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informe de Base de Datos</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            .contenedor{
                display: flex;   
                align-items: center;
            }
            .contenedor img {
                width: 20%;
                height: 20%;
                margin-left: auto;
                margin-right: auto; /* Espaciado entre la imagen y el texto, ajusta según sea necesario */
                display: block;
            }/*
            .header {
                text-align: center;
                margin-bottom: 20px;
                color: red;
            }*/
            .table-container {
                width: 100%;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <div class="contenedor">
            <div class="header">
                <h1>Informe de Base de Datos</h1>
            </div>
        </div>
        
        <div class="contenedor">
            <div class="header">
                <h1>Informacion de Operador</h1>
                <h5>Nombres: <?php echo $data['user']['nombres'] ?></h5>
                <h5>Apellidos: <?php echo $data['user']['apellidos'] ?></h5>
                <h5>Cedula: <?php echo $data['user']['cedula'] ?></h5>
                <h5>Correo: <?php echo $data['user']['correo'] ?></h5>
                <h5>Telefono: <?php echo $data['user']['telefono'] ?></h5>
                <h5>Usuario: <?php echo $data['user']['usuario'] ?></h5>
                <h5>Fecha Agregado: <?php echo $data['user']['fecha_agregado'] ?></h5>
                <h5>Estado: 
                    <?php if($data['user']['estado'] == 0){ ?>
                        Activo
                    <?php } else { ?>
                        Inactivo
                    <?php } ?>
                </h5>
                <h5>Rol: 
                    
                    <?php if($data['user']['rol'] == 1){ ?>

                        Administrador

                    <?php } else { ?>

                        Operador

                    <?php } ?>
                </h5>
            </div>
        </div>

<div class="contenedor">
    <div class="header">
        <h1>Equipos ingresados por este operador</h1>
    </div>
</div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                       
                        <th>Numero Bien</th>
                        <th>Departamento</th>
                        <th>Fecha Recibido</th>
                        <th>Problema</th>
                        <th>Estado</th>
                        <!-- Agrega más encabezados según tus campos de base de datos -->
                    </tr>
                </thead>
                <tbody>
                <?php foreach($datos['usuario']['ingresos'] as $data) { ?>
                        <tr>
                            <td> <?php echo $data['numero_bien']; ?> </td>
                            <td> <?php echo $data['departamento']; ?> </td>
                            <td> <?php echo $data['fecha_recibido']; ?> </td>
                            <td> <?php echo $data['problema']; ?> </td>
                            <td> 
                                <?php if($data['estado'] == 1){ ?> 
                                    Entregado
                                <?php } else { ?>
                                    Pendiente
                                <?php } ?>
                            </td>
                    <?php } ?>
                </tbody>
            </table>
        </div>

<div class="contenedor">
    <div class="header">
        <h1>Equipos entregados por este operador</h1>
    </div>
</div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                       
                        <th>Numero Bien</th>
                        <th>Departamento</th>
                        <th>Fecha Entrega</th>
                        <th>Autorizado Por</th>
                        <th>Problema</th>
                        <th>Conclusion</th>
                        <!-- Agrega más encabezados según tus campos de base de datos -->
                    </tr>
                </thead>
                <tbody>
                <?php foreach($datos['usuario']['entregas'] as $data) { ?>
                        <tr>
                            <td> <?php echo $data['equipo']; ?> </td>
                            <td> <?php echo $data['departamento']; ?> </td>
                            <td> <?php echo $data['fecha_aprobacion']; ?> </td>
                            <td> <?php echo $data['administrador']; ?> </td>
                            <td> <?php echo $data['problema']; ?> </td>
                            <td> <?php echo $data['conclusion']; ?> </td>
                    <?php } ?>
                </tbody>
            </table>
        </div>

<div class="contenedor">
    <div class="header">
        <h1>Historial de cuenta de usuario</h1>
    </div>
</div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Administrador</th>
                        <th>Accion</th>
                        <th>Razon</th>
                        <th>Fecha Accion</th>
                        <!-- Agrega más encabezados según tus campos de base de datos -->
                    </tr>
                </thead>
                <tbody>
                <?php foreach($datos['usuario']['historial'] as $data) { ?>
    <tr>
        <td> <?php echo isset($data['id_historial']) ? $data['id_historial'] : ''; ?> </td>
        <td> <?php echo isset($data['administrador']) ? $data['administrador'] : ''; ?> </td>
        <td> <?php echo isset($data['accion']) ? $data['accion'] : ''; ?> </td>
        <td> <?php echo isset($data['razon']) ? $data['razon'] : ''; ?> </td>
        <td> <?php echo isset($data['fecha_historial']) ? $data['fecha_historial'] : ''; ?> </td>
    </tr>
<?php } ?>

                </tbody>
            </table>
        </div>
    </body>
    </html>