<?php $datos = $operadores->index(); ?>

<h1> <?php echo $datos['titulo']; ?> edit!</h1>

<form action="" method="post">

    Nombre del operador: <input required type="text" name="nombre" id="nombre"> <br>
    Apellido del operador: <input required type="text" name="apellido" id="apellido"> <br>
    Cedula del operador: <input required type="number" max="100000000" name="cedula_identidad" id="cedula_identidad"> <br>
    Correo del operador: <input required type="text" name="correo" id="correo"><br>
     <br>
    

    

    <button type="submit">Editar</button>
</form>
