<?php
function load_method(string $class): void{
    // Normaliza la clase: quita barra inicial y convierte namespace en ruta
    $class = ltrim($class, '\\');
    $classPath = str_replace('\\', '/', $class);
    
    // Carpetas base donde buscar (por compatibilidad con SRFK clásico)
    $paths = [
        "App/controllers",
        "App/models",
        "core"
    ];

    foreach ($paths as $path) {
        // 1️⃣  Búsqueda clásica (sin namespaces)
        $file = APP_PATH . $path . "/" . basename($classPath) . ".php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }

        // 2️⃣  Búsqueda PSR-like (con namespaces)
        $file = APP_PATH . $path . "/" . $classPath . ".php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // 3️⃣  Si no se encontró, intenta con ruta absoluta al estilo PSR completo
    $file = APP_PATH . $classPath . ".php";
    if (file_exists($file)) {
        require_once $file;
        return;
    }

    // 4️⃣  Último recurso: error visible (útil para depurar)
    prx("[SRFK++] No se pudo cargar la clase: {$class}");
}




function prx($data){
	pr( $data );
	exit;
}
function vrx($data){
	vr( $data );
	exit;
}

function pr($data){
	echo "<pre>";
	print_r( $data );
	echo "</pre>";
}

function vr($data){
	echo "<pre>";
	var_dump( $data );
	echo "</pre>";
}

