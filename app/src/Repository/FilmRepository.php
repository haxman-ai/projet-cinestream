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


}






   