<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$routeCollector = require __DIR__ . '/../../config/routes.php';

$serverRequest = (new \Nyholm\Psr7\ServerRequest(
    'get',
    '/test',
    [],
    '{"name":"John"}',
    '1.1',
    []
))->withQueryParams([
    'age' => 25
]);
$router = new \Framework\Routes\Router();
$router->setRouteCollector($routeCollector);

$response = $router->execute($serverRequest);

echo PHP_EOL."StatusCode: "; print_r($response->getStatusCode()); echo PHP_EOL;
echo PHP_EOL."Body: "; var_dump((string) $response->getBody()); echo PHP_EOL;
echo PHP_EOL."Headers: "; print_r($response->getHeaders()); echo PHP_EOL;
echo PHP_EOL."Reason: "; print_r($response->getReasonPhrase()); echo PHP_EOL;

echo PHP_EOL.PHP_EOL. '-----------------------------------------' .PHP_EOL.PHP_EOL;
