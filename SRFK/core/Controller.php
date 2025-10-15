<?php

abstract class Controller {
    protected array $data = [];

    public function json($data, int $status = 200): void {
        Response::json($data, $status);
    }

    public function view(string $template, array $vars = []): void {
        extract($vars);
        include(APP_PATH . "App/views/" . $template . ".phtml");
    }
}
