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
inicioController, esto aplica para los Models tambien, todas las clases deben tener el mismo nombre del archivo

-En las vistas siempre que se cree una nueva vista, se debe meter dentro de una carpeta con el nombre del modelo al que hace 
referencia y los archivos deben llevar los mismos nombres del metodo del que dependen, es decir, todo de la vista Operadores
va en la carpeta operadores, y sus archivos llevan nombre de su respectivo metodo

-La template general con el header y el footer esta en Views/template.php, el __construct tiene el header, la navbar y la sidebar y el __destruct tiene
el footer y los scripts de JS

-El Script2.py es el que genero la secuencia de numeros para la tabla de direcciones_ip en la base de datos, la consulta se puede ver en SQL/generando bucle para 256 direcciones.sql, 
ya no tiene uso

-AVISO: HUBO QUE AGREGAR RewriteCond %{REQUEST_URI} !(\.css|\.js|\.png|\.jpg|\.gif|robots\.txt)$ [NC] AL htaccess PARA QUE LOS ESTILOS CSS SE APLICARAN CORRECTAMENTE

-El mysqlbackup.bat es un script de windows para ejecutar un respaldo semanal de la base de datos, dicho respaldo se guarda en la carpeta backup