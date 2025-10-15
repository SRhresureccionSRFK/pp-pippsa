<?php

namespace SRFK\Utils\n1\n2\n3\n4;

class Logger {
    public static function log(string $message): void {
        // Guardar log en WEB-INF/logs.log
        $file = APP_PATH . "WEB-INF/logs.log";
        $entry = "[" . date("Y-m-d H:i:s") . "] " . $message . PHP_EOL;
        // file_put_contents($file, $entry, FILE_APPEND);
		prx( $entry );
    }
}
