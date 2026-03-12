<?php

namespace Cine\App\Repository;

use Cine\App\Entity\Genre;
use PDO;

class GenreRepository
{
public function findALL() 
     
{ 

$sql = "SELECT * FROM genre";

$pdo = new PDO(
    'mysql:dbname=cine;host=mysql;charset=utf8',
    'user',
    'pwd'
);

$request = $pdo->prepare($sql);
$request->execute();

$request->setFetchMode(PDO::FETCH_CLASS, Genre::class);

return $request->fetchAll();

}



public function findByid($genreId) 
{ 
$sql = "SELECT * FROM film WHERE genre_id = id";

$pdo = new PDO('mysql:dbname=cine;host=mysql;charset=utf8','user','pwd');
$request = $pdo->prepare($sql);

$request->execute(['id'=>$genreId->getGenre_id()]);

return $request-> fetchAll(PDO::FETCH_CLASS, Genre::class);
}












}


