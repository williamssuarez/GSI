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
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/css/style.css">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/css/bootstrap.css">
    </head>
    <body>

        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo URL; ?>inicio">Sistema GSI</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">        
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URL; ?>operadores/">Operadores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URL; ?>equipos/">Equipos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URL; ?>direcciones/">Direcciones</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-sm-2" type="search" placeholder="Buscar">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>
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