<?php

class Router {
    private array $config;

    public function __construct(array $config) {
        $this->config = $config;
    }

    public function dispatch(): void {
        $controller = $_GET["controller"] ?? $this->config["default_controller"];
        $action = $_GET["action"] ?? $this->config["default_action"];

        $controllerName = ucfirst($controller) . "Controller";
        $controllerPath = APP_PATH . "App/controllers/" . $controllerName . ".php";

        if (!file_exists($controllerPath)) {
//            Response::error(404, "Controller '$controllerName' not found.");
        }

        require_once($controllerPath);
        $instance = new $controllerName();

        if (!method_exists($instance, $action)) {
  //          Response::error(404, "Action '$action' not found in $controllerName.");
        }

        CallHelper::safeCall([$instance, $action]);
    }
}
