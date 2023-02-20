<?php

$host = "0.0.0.0";
$hostname = "localhost";
$port = 9501;

$server = new Swoole\HTTP\Server($host , $port);

$server->set([
    'worker_num' => 4,      // The number of worker processes to start
    'task_worker_num' => 4,  // The amount of task workers to start
    'backlog' => 128,       // TCP backlog connection number
    'input_buffer_size' => 32 * 1024*1024, //Configure the memory size of the server receive input buffer. Default value is 2M. Value in bytes (in this example: 32MB).
    'buffer_output_size' => 32 * 1024*1024, //Set the output memory buffer server send size. The default value is 2M. Value in bytes (in this example: 32MB).
]);


// Triggered when new worker processes starts
$server->on("WorkerStart", function($server, $workerId)
{
    echo PHP_EOL."New worker started: {$workerId}".PHP_EOL;
});

$server->on('Task', function (Swoole\Server $server, $task_id, $reactorId, $data)
{
    echo "Task Worker Process received data";

    echo "#{$server->worker_id}\tonTask: [PID={$server->worker_pid}]: task_id=$task_id, data_len=" . strlen($data) . "." . PHP_EOL;

    $server->finish($data);
});

// Triggered when the HTTP Server starts, connections are accepted after this callback is executed
$server->on('start', function (Swoole\HTTP\Server $server) use ($hostname, $port) {
    echo sprintf('Swoole http server is started at http://%s:%s' . PHP_EOL, $hostname, $port);
});

// The main HTTP server request callback event, entry point for all incoming HTTP requests
$server->on('Request', function(Swoole\HTTP\Request $request, Swoole\HTTP\Response $response)
{
    echo PHP_EOL."------ Server Request ------".PHP_EOL;
    echo "* - Method: ".$request->getMethod().PHP_EOL;
    echo "* - request_uri: ".$request->server['request_uri'].PHP_EOL;
    echo "* - header: ";print_r($request->header);echo PHP_EOL;
    echo "* - body: ";print_r($request->getData());echo PHP_EOL;
    echo "* - Server Params: ";print_r($request->server);echo PHP_EOL;
    echo "* - Query Params: ";print_r($request->get);echo PHP_EOL;
    echo "* - Parsed Body: ";print_r($request->post ?? []);echo PHP_EOL;
    //echo "* - Raw Body: ";print_r(file_get_contents('php://input'));echo PHP_EOL;
    echo "* - Body Raw Content: ";print_r($request->getContent());echo PHP_EOL;
    echo PHP_EOL."---------------------".PHP_EOL;
    $response->header('content-type', 'application/json');
    $response->status(201);
    $response->end(json_encode(['message'=>'Created!!!']));
    //$response->end('<h1>Hello World!</h1>');
});

// Triggered when the server is shutting down
$server->on("Shutdown", function($server, $workerId)
{
    echo PHP_EOL."Server is shutdown: {$workerId}".PHP_EOL;
});

// Triggered when worker processes are being stopped
$server->on("WorkerStop", function($server, $workerId)
{
    echo PHP_EOL."Worker stoped: {$workerId}".PHP_EOL;
});

$server->start();