-El htaccess es el que se encarga de manejar las rutas

-Para iniciar el servidor local 9000 de Windows, ver el txt servidor local 9000.txt 

-Esto sigue una arquitectura de diseño MVC, Modelo Vista Controlador, donde en el Modelo se definen las entidades u objetos 
de interaccion con las tablas de la base de datos, junto con consulta simples, en Repository se guardan los procesos y consultas 
mas complejos entre modelos, en Controllers se interactua con la vista y el modelo y tambien se carga la vista para el usuario

-Al final todos los archivos se cargan en el index.php, el Autoload carga las clases necesarias, el Request.php obtiene la url,
la limpia, y le asigna las variables controlador, metodo, y argumento, si ningun controlador es especificado para $controlador
entonces a la variable se le asignara el controlador "inicio"

-El Enrutador.php es el que realmente se encarga del enrutamiento, a $controlador le concatena la palabra "Controller" y mas abajo
se concatena el resto de la ruta, la funcion se ve asi

$controlador = $request->getControlador() . "Controller";
$ruta = ROOT . "Controllers" . DS . $controlador . ".php";

-Es por eso que todos los controladores que se creen deben ser en minuscula y la palabra "Controller" pegada, y el nombre
de la clase debe ser exactamente igual al del archivo, es decir, la clase principal en inicioController.php debe llamarse
inicioController, esto no aplica para los Models

-En las vistas siempre que se cree una nueva vista, se debe meter dentro de una carpeta con el nombre del modelo al que hace 
referencia y los archivos deben llevar los mismos nombres del metodo del que dependen, es decir, todo de la vista Operadores
va en la carpeta operadores, y sus archivos llevan nombre de su respectivo metodo

-La template general con el header y el footer esta en Views/template.php, el __construct tiene el header y el __destruct tiene
el footer

-El Script2.py es el que genera las ip para la tabla en la base de datos

-AVISO: HUBO QUE AGREGAR RewriteCond %{REQUEST_URI} !(\.css|\.js|\.png|\.jpg|\.gif|robots\.txt)$ [NC] AL htaccess PARA QUE LOS ESTILOS CSS SE APLICARAN CORRECTAMENTE


---These are the steps to follow when you want your PHP application to be installed on a LAN server (not on web)

Get the internal IP or Static IP of the server (Ex: 192.168.1.193)
Open XAMPP>apache>conf>httpd.conf file in notepad
Search for Listen 80
Above line would read like- #Listen 0.0.0.0:80 / 12.34.56.78:80
Change the IP address and replace it with the static IP
Save the httpd.conf file ensuring that the server is pointed to #Listen 192.168.1.193:80
In the application root config.php (db connection) replace localhost with IP address of the server
Note: If firewall is installed, ensure that you add the http port 80 and 8080 to exceptions and allow to listen. Go to Control Panel>Windows Firewall>Allow a program to communicate through windows firewall>Add another program Name: http Port: 80 Add one more as http - 8080

If IIS (Microsoft .Net Application Internet Information Server) is installed with any Microsoft .Net application already on server, then it would have already occupied 80 port. In that case change the #Listen 192.168.1.193:80 to #Listen 192.168.1.193:8080

Hope this helps!