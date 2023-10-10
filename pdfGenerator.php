<?php // pdfGenerator.php

session_start();

require_once "Config/Autoload.php";
require_once "vendor/autoload.php";

if(isset($_SESSION['pdfContent'])){
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="prueba.pdf"');
    echo $_SESSION['pdfContent'];
    ob_end_clean();
    exit;
}

?>
