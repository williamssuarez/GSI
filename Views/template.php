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
        <title>Sistema GSI</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/Views/template/css/bootstrap.css">
        <link rel="stylesheet" href="/Views/template/css/bootstrap.min.css">
        <link rel="stylesheet" href="/Views/template/css/bootstrap.rtl.css">
        <link rel="stylesheet" href="/Views/template/css/bootstrap.rtl.min.css">
        <script src="/Views/template/js/jquery-3.6.0.js"></script>
        <script src="/Views/template/js/bootstrap.js"></script>
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