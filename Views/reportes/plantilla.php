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
                <img src="<?php echo URL; ?>Views/template/img/2.png" alt="">
                <h1>Informe de Base de Datos</h1>
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Numero de Bien</th>
                        <th>Departamento</th>
                        <th>Fecha Recibido</th>
                        <th>Recibido Por</th>
                        <th>Problema </th>
                        <th>Estado</th>
                        <!-- Agrega más encabezados según tus campos de base de datos -->
                    </tr>
                </thead>
                <tbody>
                <?php foreach($datos['equipos'] as $data) { ?>
                        <tr>
                            <td> <?php echo $data['numero_bien']; ?> </td>
                            <td> <?php echo $data['departamento']; ?> </td>
                            <td> <?php echo $data['fecha_recibido']; ?> </td>
                            <td> <?php echo $data['nombre_operador']; ?> </td>
                            <td> <?php echo $data['problema']; ?> </td>
                            <td>
                                <?php
                                if ($data['estado'] == 0) { ?>

                                    <span class=" font-weight-bold" >
                                        Pendiente <i class="fa-solid fa-circle-exclamation" style="color: #d4ac40;"></i>
                                    </span>

                                <?php } elseif($data['estado'] == 2) { ?>

                                    <span class=" font-weight-bold" >
                                        En revision <i class="fa-solid fa-circle-info" style="color: #0045bd;"></i>
                                    </span>

                                <?php } else { ?>

                                    <span class=" font-weight-bold" >
                                        Entregado <i class="fa-solid fa-circle-check" style="color: #3aa413;"></i>
                                    </span>

                                <?php } ?>
                            </td>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>