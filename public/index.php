<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$coreDirectory = realpath(__DIR__.'/../../cinetech_core');

try {
    if (!is_readable($coreDirectory.'/vendor/autoload.php')) {
        die('Impossible de lire autoload.php');
    }
    
    if (!is_readable($coreDirectory.'/bootstrap/app.php')) {
        die('Impossible de lire app.php');
    }
    
    require $coreDirectory.'/vendor/autoload.php';
    
    $app = require_once $coreDirectory.'/bootstrap/app.php';
    
    $kernel = $app->make(Kernel::class);
    
    $response = $kernel->handle(
        $request = Request::capture()
    )->send();
    
    $kernel->terminate($request, $response);
    
} catch (Throwable $e) {
    throw $e;
}
