
<?php

//FUNCIONES PARA EL CONTROLADOR FRONTAL
//Carga un controlado u otro en funcion de lo que se pase por la URL
function cargarControlador($controller) {

    $controlador = ucwords($controller) . 'Controller';
    $strFileController = 'controller/' . $controlador . '.php';

    if (!is_file($strFileController)) {
        $strFileController = 'controller/' . ucwords(CONTROLADOR_DEFECTO) . 'Controller.php';
    }
    //Incluye el ficheroy lo devuelve
    require_once $strFileController;
    $controllerObj = new $controlador();
    return $controllerObj;
}

function cargarAccion($controllerObj, $action) {

    $accion = $action;
    $controllerObj->$accion();
}

function lanzarAccion($controllerObj) {

    if (isset($_GET["action"]) && method_exists($controllerObj, $_GET["action"])) {
        cargarAccion($controllerObj, $_GET["action"]);
    } else {
        cargarAccion($controllerObj, ACCION_DEFECTO);
    }
}

?>
