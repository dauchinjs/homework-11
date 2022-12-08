<?php declare(strict_types=1);
// login registration, iespeja redzet manus 10 izveletus. cenas un to maina pedejas 24h
// AAPL (Apple), TSLA (TESLA), NVDA(NVIDIA), MA(Mastercard), KO(Coca-Cola)
// NKE(Nike), DIS(Walt Disney), UPS(United Parcel Service), NFLX(Netflix), PYPL(PayPal)

require_once "../vendor/autoload.php";

use App\Controllers\CompanyControllers\CompanyController;
use App\Controllers\UserControllers\LoginController;
use App\Controllers\UserControllers\LogoutController;
use App\Controllers\UserControllers\RegisterController;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = Dotenv::createImmutable('/home/davids/Desktop/CODELEX/9.dala');
$dotenv->load();

session_start();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/', [CompanyController::class, 'execute']);

    $route->addRoute('GET', '/register', [RegisterController::class, 'showForm']);
    $route->addRoute('POST', '/register', [RegisterController::class, 'store']);

    $route->addRoute('GET', '/login', [LoginController::class, 'showForm']);
    $route->addRoute('POST', '/login', [LoginController::class, 'execute']);

    $route->addRoute('GET', '/logout', [LogoutController::class, 'exit']);
});

$loader = new FilesystemLoader('../views');
$twig = new Environment($loader);

$authVariables = [
    \App\ViewVariables\AuthViewVariables::class,
    \App\ViewVariables\ErrorsViewVariables::class
];

foreach ($authVariables as $variable) {
    /** @var \App\ViewVariables\ViewVariables $variable */
    $variable = new $variable;
    $twig->addGlobal($variable->getName(), $variable->getValue());
}

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;

        $response = (new $controller)->{$method}($vars);

        if ($response instanceof \App\Template) {
            echo $twig->render($response->getPath(), $response->getParameters());

            unset($_SESSION['error']);
        }

        if ($response instanceof \App\Redirect) {
            header('Location: ' . $response->getUrl());
        }

        break;
}