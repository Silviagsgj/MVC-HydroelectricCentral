
<?php
//Configuración global. Definición de variables
require_once 'config/global.php';

//Base para los controladores. Clase ControladorBase, la heredarán los controladores
require_once 'core/ControladorBase.php';

//Funciones para el controlador frontal, funciones que cargan el controlador y la acción.
require_once 'core/ControladorFrontal.func.php';

//Preguntamos por la petición recibida para cargar controladores y acciones
//La mayoría de las peticiones irán por GET.
//Si no van por get se cargará el controlaor por defecto
//Utiliza las funciones del ControladorFrontal.func.php
if(isset($_GET["controller"])){
    $controllerObj=cargarControlador($_GET["controller"]);
    lanzarAccion($controllerObj);
}else{
    $controllerObj=cargarControlador(CONTROLADOR_DEFECTO);
    lanzarAccion($controllerObj);
}
?>