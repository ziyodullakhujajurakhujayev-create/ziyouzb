<?php

require __DIR__ . '/../app/Helpers.php';
require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/Core/Database.php';
require __DIR__ . '/../app/Core/Controller.php';
require __DIR__ . '/../app/Models/UserModel.php';
require __DIR__ . '/../app/Models/ErpModel.php';
require __DIR__ . '/../app/Services/AiAdvisor.php';
require __DIR__ . '/../app/Services/PdfReport.php';
require __DIR__ . '/../app/Controllers/AuthController.php';
require __DIR__ . '/../app/Controllers/DashboardController.php';
require __DIR__ . '/../app/Controllers/OperationsController.php';
require __DIR__ . '/../app/Controllers/ReportsController.php';

session_start();

$routes = [
    'GET' => [
        '/' => [AuthController::class, 'loginPage'],
        '/login' => [AuthController::class, 'loginPage'],
        '/dashboard' => [DashboardController::class, 'index'],
        '/inventory' => [OperationsController::class, 'inventory'],
        '/production' => [OperationsController::class, 'production'],
        '/quality' => [OperationsController::class, 'quality'],
        '/warehouse' => [OperationsController::class, 'warehouse'],
        '/rolls' => [OperationsController::class, 'rolls'],
        '/reports' => [ReportsController::class, 'index'],
        '/reports/export' => [ReportsController::class, 'export'],
        '/reports/audit' => [ReportsController::class, 'audit'],
        '/logout' => [AuthController::class, 'logout'],
        '/api/alerts' => [ReportsController::class, 'apiAlerts'],
    ],
    'POST' => [
        '/login' => [AuthController::class, 'login'],
    ],
];

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$route = $routes[$method][$uri] ?? null;

if (!$route) {
    http_response_code(404);
    echo '<h1>404</h1><p>Page not found.</p>';
    exit;
}

[$controllerName, $action] = $route;
$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    http_response_code(500);
    echo 'Action not found.';
    exit;
}

$controller->$action();
