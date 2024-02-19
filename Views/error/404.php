<!-- 404 Error Text -->
<div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Pagina No encontrada</p>
    <p class="text-gray-500 mb-0">Parece que has llegado al final del mundo...</p>
    <a href="<?php echo URL; ?>inicio/index">&larr; Presiona aqui para volver al inicio</a>
</div>
<?php
if($_SESSION['rol'] == 1) { //es admin
    require_once "Views/footers/footer.php";
} else {
    require_once "Views/footers/footerOpr.php";
}
?>