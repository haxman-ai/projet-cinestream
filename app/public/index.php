<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../.env.php';

use Cine\App\Controller\FilmController;
use Cine\App\Repository\FilmRepository; 

if (isset($_GET['action'])) {
    $route = $_GET['action'];
} else {
    $route = 'index';
}


$repository = new FilmRepository(); 

$filmController = new FilmController($repository);



if ($route === 'index') {
    $filmController->index();
} elseif ($route === 'show') {
    $filmController->show();
} elseif ($route === 'add') {
    $filmController->add();
} elseif ($route === 'update') {
    $filmController->update();
} elseif ($route === 'delete') {
    $filmController->delete();
} elseif ($route === 'save') {
    $filmController->save();
} else {
    echo "Désolé, cette page n'existe pas !";
}