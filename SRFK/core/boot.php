<?php

// Funciones globales y autoload
require(APP_PATH . "SRFK/core/functions.php");

spl_autoload_register("load_method");

// Cargar configuración global
Register::$config = require(APP_PATH . "WEB-INF/config.php");

// Conectar base de datos
DB::runDB();

// Iniciar router principal
try {
    $router = new Router(Register::$config);
    $router->dispatch();
} catch (Throwable $ex) {
	prx( $ex->getMessage() );
//    Response::error(500, "[SRFK++] Error: " . $ex->getMessage());
}



define('BASEURL', Register::$config["domain"]);
define('DEFAULT_UPLOADS', APP_PATH . Register::$config["path_uploads"] . "/");


