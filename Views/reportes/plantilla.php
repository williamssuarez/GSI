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
                <h1>Informacion de Equipo</h1>
                <h5>Numero de bien: <?php echo $data['equipo'] ?></h5>
                <h5>Usuario: <?php echo $data['usuario'] ?></h5>
                <h5>Departamento: <?php echo $data['departamento'] ?></h5>
                <h5>Fecha Registrado: <?php echo $data['fecha_registro'] ?></h5>
                <h5>CPU: <?php echo $data['cpu'] ?></h5>
                <h5>RAM: <?php echo $data['memoria_ram'] ?> GB</h5>
                <h5>Almacenamiento: <?php echo $data['almacenamiento'] ?> GB</h5>
                <h5>O.S: <?php echo $data['nombre'] ?></h5>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                       
                        <th>Fecha Recibido</th>
                        <th>Recibido Por</th>
                        <th>Fecha Aprobacion</th>
                        <th>Autorizado Por</th>
                        <th>Entregado Por</th>
                        <th>Problema </th>
                        <th>Conclusion </th>
                        <!-- Agrega más encabezados según tus campos de base de datos -->
                    </tr>
                </thead>
                <tbody>
                <?php foreach($datos['equipos'] as $data) { ?>
                        <tr>
                            <td> <?php echo $data['fecha_recibido']; ?> </td>
                            <td> <?php echo $data['nombres']; ?> </td>
                            <td> <?php echo $data['fecha_aprobacion']; ?> </td>
                            <td> <?php echo $data['administrador']; ?> </td>
                            <td> <?php echo $data['entregado_por']; ?> </td>
                            <td> <?php echo $data['problema']; ?> </td>
                            <td> <?php echo $data['conclusion']; ?> </td>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>