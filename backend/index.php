<?php

require 'vendor/autoload.php';
require 'generated-conf/config.php';  // Configuration de la connexion à la base

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Exemple simple de retour JSON
header('Content-Type: application/json');

$dispatcher = simpleDispatcher(function(RouteCollector $r) {
  // Statiques
  $r->addRoute('GET', '/album/index', ['Chinook\Controllers\AlbumController', 'index']);
  $r->addRoute('GET', '/album/index/details', ['Chinook\Controllers\AlbumController', 'details']);
  $r->addRoute('POST', '/album', ['Chinook\Controllers\AlbumController', 'store']);
  $r->addRoute('PUT', '/album', ['Chinook\Controllers\AlbumController', 'update']);
  $r->addRoute('DELETE', '/album', ['Chinook\Controllers\AlbumController', 'delete']);

  // $r->addRoute('GET', '/playlist/index', ['Chinook\Controllers\PlaylistController', 'index']);
  // $r->addRoute('POST', '/playlist/index', ['Chinook\Controllers\PlaylistController', 'store']);
  // $r->addRoute('PUT', '/playlist/index', ['Chinook\Controllers\PlaylistController', 'update']);
  // $r->addRoute('DELETE', '/playlist/index', ['Chinook\Controllers\PlaylistController', 'delete']);

  
  $r->addRoute('GET', '/artist/index', ['Chinook\Controllers\ArtistController', 'index']);
  $r->addRoute('GET', '/artist/index/details', ['Chinook\Controllers\ArtistController', 'details']);
  $r->addRoute('POST', '/artist', ['Chinook\Controllers\ArtistController', 'store']);
  $r->addRoute('PUT', '/artist', ['Chinook\Controllers\ArtistController', 'update']);
  $r->addRoute('DELETE', '/artist', ['Chinook\Controllers\ArtistController', 'delete']);

  $r->addRoute('GET', '/track/index', ['Chinook\Controllers\TrackController', 'index']);
  $r->addRoute('GET', '/track/index/details', ['Chinook\Controllers\TrackController', 'details']);
  $r->addRoute('GET', '/track/form-utils', ['Chinook\Controllers\TrackController', 'form_utils']);
  $r->addRoute('POST', '/track', ['Chinook\Controllers\TrackController', 'store']);
  $r->addRoute('PUT', '/track', ['Chinook\Controllers\TrackController', 'update']);
  $r->addRoute('DELETE', '/track', ['Chinook\Controllers\TrackController', 'delete']);

  $r->addRoute('GET', '/dashboard/metrics', ['Chinook\Controllers\DashboardController', 'metrics']);
  $r->addRoute('GET', '/dashboard/revenue-trend', ['Chinook\Controllers\DashboardController', 'revenue_trend']);
  $r->addRoute('GET', '/dashboard/genre-performance', ['Chinook\Controllers\DashboardController', 'genre_performance']);
  $r->addRoute('GET', '/dashboard/top-customers', ['Chinook\Controllers\DashboardController', 'top_customers']);
  $r->addRoute('GET', '/dashboard/top-albums', ['Chinook\Controllers\DashboardController', 'top_albums']);
  $r->addRoute('GET', '/dashboard/top-tracks', ['Chinook\Controllers\DashboardController', 'top_tracks']);
  $r->addRoute('GET', '/dashboard/tracks-performance', ['Chinook\Controllers\DashboardController', 'tracks_performance']);

  // Dynamique
  $r->addRoute('GET', '/album/{id:\d+}', ['Chinook\Controllers\AlbumController', 'show']);
  $r->addRoute('GET', '/album/{id:\d+}/tracks', ['Chinook\Controllers\AlbumController', 'tracks']);
  $r->addRoute('GET', '/artist/{id:\d+}/albums', ['Chinook\Controllers\ArtistController', 'albums']);
  $r->addRoute('GET', '/playlist/{id:\d+}/tracks', ['Chinook\Controllers\PlaylistController', 'tracks']);
});

// Récupérer la requête
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Nettoyer l’URI (enlever query string)
if (false !== $pos = strpos($uri, '?')) {
  $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

// Dispatcher
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
  case FastRoute\Dispatcher::NOT_FOUND:
    http_response_code(404);
    echo json_encode(["error" => "Route not found"]);
    break;

  case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    break;

  case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1]; // ['ControllerClass', 'method']
    $vars = $routeInfo[2];    // paramètres {id}, etc.
    
    [$class, $method] = $handler;
    $controller = new $class();
    $controller->$method(...array_values($vars));
    break;
}