<!-- Mensaje Error Text -->
<div class="text-center">
    <div class="error mx-auto" data-text="Error">Ups...</div>
    <p class="lead text-gray-800 mb-5">Parece que ha ocurrido un error</p>
    <p class="text-gray-500 mb-0">Problema de redireccionamiento, Reportalo al administrador!</p>
    <a href="<?php echo URL; ?>operadores/index">&larr; Presiona aqui para volver a los operadores</a>
</div>
<?php
if($_SESSION['rol'] == 1) { //es admin
    require_once "Views/footers/footer.php";
} else {
    require_once "Views/footers/footerOpr.php";
}
?>