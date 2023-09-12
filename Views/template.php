<?php namespace Views;

    $template = new Template();

class Template{

    public function __construct()
    {
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Administracion de estudiantes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./template/css/bootstrap.css">
        <script src="./template/js/jquery-3.6.0.js"></script>
        <script src="./template/js/bootstrap.js"></script>
    </head>
    <body>
            
<?php
    }


    public function __destruct()
    {
?>

    </body>
    </html>

<?php
        
    }
}



?>