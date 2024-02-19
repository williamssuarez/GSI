<?php


namespace Controllers;


class plantillasController
{
    public function __construct()
    {
        if (!isset($_SESSION['usuario'])) {
            // El usuario no está autenticado, muestra la alerta y redirige al formulario de inicio de sesión.
            echo '<script>
            Swal.fire({
                title: "Error",
                text: "Tienes que iniciar sesión primero!",
                icon: "warning",
                showConfirmButton: true,
                confirmButtonColor: "#3464eb",
                confirmButtonText: "Iniciar Sesión",
                customClass: {
                    confirmButton: "rounded-button" // Identificador personalizado
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . URL . 'login/index";
                }
            }).then(() => {
                window.location.href = "' . URL . 'login/index"; // Esta línea se ejecutará cuando se cierre la alerta.
            });
            </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
        }
    }

    public function getPlantilla() {
        /*$filePath = __DIR__ . '/../pdf/plantilla.php';
        $contents = file_get_contents($filePath);*/
        $contents = '<body>
    <header class="clearfix">
        <div id="logo">
            <img src="[logo_path]" width="100" height="90">
        </div>
        <div id="company" class="clearfix">
            <div><h2>MI EMPRESA SA DE CV</h2></div>

            <div>HEHD00000123</div>
            <div>Av. Robles, Comitan, Chiapas</div>
            <div>9600000</div>
        </div>
        <div id="logo2">
            <img src="[logo_path2]" width="100" height="90">
        </div>
        <br>
        <div id="project">
            <div><span>CLIENTE: </span> Alberto Herrera Aguilar</div>
        </div>
        <div id="project">
            <div><span>FECHA: </span> 05/02/2024</div>
        </div>
    </header>
    <main>
        <p>Desglose de Productos</p>
        <table>
            <thead>
                <tr>
                    <th class="qty">CANTIDAD</th>
                    <th class="qty">CLAVE</th>
                    <th class="desc">PRODUCTO</th>
                    <th>P/U</th>
                    <th>IMPORTANTE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="qty">2</td>
                    <td class="desc">P001</td>
                    <td class="desc">Cocacola 600 ML</td>
                    <td class="total">$ 18.00</td>
                    <td class="total">$ 36.00</td>
                </tr>
                <tr>
                    <td class="qty" colspan="4"><strong>TOTAL</strong></td>
                    <td class="total"><strong>$ 36.00</strong></td>
                </tr>
            </tbody>
        </table>

        <p>Este no es un comprobante fiscal</p>
    </main>
    <footer>
        
    </footer>
</body>';
        return $contents;
    }

}