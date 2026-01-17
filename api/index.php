<?php

// 1. Register the Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 2. Bootstrap the Application
$app = require __DIR__ . '/../bootstrap/app.php';

// 3. Run the Application (Handle the Request)
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
