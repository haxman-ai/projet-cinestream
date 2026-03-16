<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../.env.php';

use Cine\App\Controller\FilmController;

$route = $_GET['route'] ?? 'index';

$filmController = new FilmController();

if ($route === 'index') {
    $filmController->index();
} elseif ($route === 'show') {
    $filmController->show();
} elseif ($route === 'update') {
    $filmController->update();
} elseif ($route === 'delete') {
    $filmController->delete();
} elseif ($route === 'save') {
    $filmController->save();
} elseif ($route === 'search') { 
    $filmController->search();
} elseif ($route === 'showTmdb') {
    $filmController->showTmdb();
} elseif ($route === 'add') {
    $filmController->add();
} else {
    echo 'page introuvable';
}