<?php

class Response {

    public static function json(mixed $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function html(string $html, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: text/html; charset=utf-8');
        echo $html;
        exit;
    }

    public static function error(int $code, string $message): void {
        http_response_code($code);
        header('Content-Type: text/plain; charset=utf-8');
        echo "[SRFK++] Error $code: $message";
        exit;
    }
}
