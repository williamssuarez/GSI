<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte PDF</title>
    <style>
        /* Agrega estilos CSS aquí */
    </style>
</head>
<body>
    <h1>{titulo}</h1>
    <table border="1">
        <tr>
            <th>Columna 1</th>
            <th>Columna 2</th>
        </tr>
        <tr>
            <td>{dato1}</td>
            <td>{dato2}</td>
        </tr>
    </table>
</body>
</html>
