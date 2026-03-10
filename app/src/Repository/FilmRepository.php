<?php

namespace Cine\App\Repository;

use PDO;

class FilmRepository
{
    public function findAll()
    {
        $sql = " SELECT * FROM film ";
        $pdo = new PDO('mysql:dbname=cine;host=mysql;charset=utf8', 'user', 'pwd');
        $request = $pdo->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


public function find($id)
{
    // On change "genre" par "film" et "name" par "*" (toutes les colonnes)
    $sql = "SELECT * FROM film WHERE id = :id";
    
    $pdo = new PDO('mysql:dbname=cine;host=mysql;charset=utf8', 'user', 'pwd');
    $request = $pdo->prepare($sql);

    $request->execute(['id' => $id]);

    return $request->fetch(PDO::FETCH_ASSOC);
}





}







   