<?php

// Afficher toutes les erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Debug de la méthode HTTP et des headers
echo "Méthode HTTP : " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "URI demandée : " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Script Name : " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "Document Root : " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<hr>";

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Définir le chemin vers le dossier cinetech_core
$coreDirectory = realpath(__DIR__.'/../../cinetech_core');
echo "Core Directory : " . $coreDirectory . "<br><hr>";

try {
    if (!is_readable($coreDirectory.'/vendor/autoload.php')) {
        die('Impossible de lire autoload.php');
    }
    echo "✓ autoload.php est lisible<br>";
    
    if (!is_readable($coreDirectory.'/bootstrap/app.php')) {
        die('Impossible de lire app.php');
    }
    echo "✓ app.php est lisible<br>";
    
    require $coreDirectory.'/vendor/autoload.php';
    echo "✓ Autoloader chargé<br>";
    
    $app = require_once $coreDirectory.'/bootstrap/app.php';
    echo "✓ App bootstrapped<br>";
    
    $kernel = $app->make(Kernel::class);
    echo "✓ Kernel créé<br>";
    
    // Capturer la requête et afficher ses détails
    $request = Request::capture();
    echo "Requête capturée :<br>";
    echo "- Path: " . $request->path() . "<br>";
    echo "- URL: " . $request->url() . "<br>";
    echo "- Full URL: " . $request->fullUrl() . "<br>";
    echo "<hr>";
    
    $response = $kernel->handle($request)->send();
    echo "✓ Requête traitée<br>";
    
    $kernel->terminate($request, $response);
    echo "✓ Requête terminée<br>";
    
} catch (Throwable $e) {
    echo "<div style='color: red; padding: 10px; border: 1px solid red;'>";
    echo "<strong>ERREUR :</strong><br>";
    echo $e->getMessage() . "<br>";
    echo "Fichier : " . $e->getFile() . "<br>";
    echo "Ligne : " . $e->getLine() . "<br>";
    echo "Trace : <pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
    die();
}
