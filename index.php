<?php
/**
 * SRFK++ Framework
 * Front Controller – punto de entrada de todas las peticiones
 */


declare(strict_types=1);

// Control de cache y sesión
header("Cache-Control: must-revalidate");
session_start();

// Configura zona horaria
date_default_timezone_set('America/Mexico_City');

// Error reporting (DEBUG: On, producción: Off)
ini_set('display_errors', 'On'); 
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Separador de directorios
define('DS', DIRECTORY_SEPARATOR);

// Define ruta base de la app
$app_dir = realpath(dirname(__FILE__));
define('APP_PATH', str_replace("\\", "/", $app_dir) . "/");

// Boot del framework (DB, defaults, etc.)
require_once(APP_PATH . "SRFK/core/boot.php");

