<?php
use cine\App\filmCONtrolller;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../.env.php';

if(isset($_GET['action'])) {
    $route = $_GET['action'];
} else {
    $route = 'index';
}


$filmCONtroller = new filmCONtroller;

if ($route === 'index') {
    $filmCONtroller->index();
} elseif ($route === 'show') {
    $filmCONtroller->show();
} elseif ($route === 'add') {
    $filmCONtroller->add();
} elseif ($route === 'update') {
    $filmCONtroller->update();
} elseif ($route === 'delete') {
    $filmCONtroller->delete();
}elseif($route === 'save'){
    $filmCONtroller->save();
}