<?php

namespace Cine\App\Repository;


use pdo; 



class GenreRepository
{

     public function findAll()
    {
        $sql = " SELECT * FROM genre ";
        $pdo = new PDO('mysql:dbname=cine;host=mysql;charset=utf8', 'user', 'pwd');
        $request = $pdo->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
    }








}



