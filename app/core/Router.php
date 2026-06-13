<?php

class Router {
    private $routes;
    private $viewPath = 'app/views/page/';

    public function __construct() {
        // rutas Del Sistema
        $this->routes = require 'config/routes.php';
    }

    public function resolve($action, $userRole = null) {
        // Acceso a rutas
        if (!isset($this->routes[$action])) {
            return [
                'file' => $this->viewPath . 'error.php',
                'menu' => false,
                'status' => 404
            ];
        }

        $route = $this->routes[$action];

        // Acceso por rol
        $hasAccess = in_array('*', $route['roles']) || ($userRole && in_array($userRole, $route['roles']));

        if (!$hasAccess) {
            return [
                'file' => $this->viewPath . 'denied.php',
                'menu' => true,
                'status' => 403
            ];
        }

        // Ruta Valida
        return [
            'file' => $this->viewPath . $route['vista'],
            'menu' => $route['menu'],
            'status' => 200
        ];
    }
}
