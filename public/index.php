<?php declare(strict_types=1);

require_once "../vendor/autoload.php";

use App\Controllers\BuySellControllers\BuySellController;
use App\Controllers\BuySellControllers\TransactionsController;
use App\Controllers\BuySellControllers\TransferController;
use App\Controllers\StocksController\StocksController;
use App\Controllers\UserControllers\LoginController;
use App\Controllers\UserControllers\LogoutController;
use App\Controllers\UserControllers\MoneyController;
use App\Controllers\UserControllers\ProfileController;
use App\Controllers\UserControllers\RegisterController;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Company\MarketApiStocksRepository;
use App\ViewVariables\ViewVariables;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

session_start();

$container = new DI\Container();
$container->set(
    CompanyRepository::class,
    \DI\create(MarketApiStocksRepository::class),
);

$dotenv = Dotenv::createImmutable('/home/davids/Desktop/CODELEX/9.dala');
$dotenv->load();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/', [StocksController::class, 'execute']);
    $route->addRoute('GET', '/stock', [StocksController::class, 'execute']);

    $route->addRoute('GET', '/buySell', [BuySellController::class, 'index']);
    $route->addRoute('POST', '/buySell', [BuySellController::class, 'execute']);

    $route->addRoute('GET', '/search', [StocksController::class, 'search']);

    $route->addRoute('GET', '/profile', [ProfileController::class, 'showForm']);
    $route->addRoute('POST', '/wallet', [MoneyController::class, 'depositWithdraw']);
    $route->addRoute('GET', '/transactions', [TransactionsController::class, 'showForm']);

    $route->addRoute('GET', '/transfer', [TransferController::class, 'showForm']);
    $route->addRoute('POST', '/transfer', [TransferController::class, 'execute']);

    $route->addRoute('GET', '/register', [RegisterController::class, 'showForm']);
    $route->addRoute('POST', '/register', [RegisterController::class, 'execute']);

    $route->addRoute('GET', '/login', [LoginController::class, 'showForm']);
    $route->addRoute('POST', '/login', [LoginController::class, 'execute']);

    $route->addRoute('GET', '/logout', [LogoutController::class, 'exit']);
});

$loader = new FilesystemLoader('../views');
$twig = new Environment($loader);

$authVariables = [
    \App\ViewVariables\AuthViewVariables::class,
    \App\ViewVariables\ErrorsViewVariables::class,
    \App\ViewVariables\ProfitViewVariables::class,
    \App\ViewVariables\StocksViewVariables::class,
    \App\ViewVariables\TransactionsViewVariables::class,
    \App\ViewVariables\UserStocksViewVariables::class,
    \App\ViewVariables\StockAmountViewVariable::class,
];

foreach ($authVariables as $variable) {
    /** @var ViewVariables $variable */
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

        $response = $container->get($controller)->{$method}($vars);

        if ($response instanceof \App\Template) {
            echo $twig->render($response->getPath(), $response->getParameters());

            unset($_SESSION['error']);
        }

        if ($response instanceof \App\Redirect) {
            header('Location: ' . $response->getUrl());
        }

        break;
}