<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';


// Create Container
$container = new Container();
AppFactory::setContainer($container);

// Set view in Container
$container->set('view', function() {
    return Twig::create(__DIR__ . '/../templates',
        ['cache' => __DIR__ . '/../cache']);
});

// Create App
$app = AppFactory::create();

// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app));


// Example route
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $this->get('view')->render($response, 'hello.twig', [
        'name' => $args['name']
    ]);
});

$app->get('/login/{name}', function ($request, $response, $args) {
    return $this->get('view')->render($response, 'login.twig', [
        'name' => $args['name']
    ]);
});

$app->get('/', function (Request $request, Response $response, $args) {

    $response->getBody()->write("");
    return $response;
});

////
//$app->get('/test', function (Request $request, Response $response, $args) {
//    $response->getBody()->write(headHtml()."
//
//
//    ");
//    return $response;
//});

$app->run();


