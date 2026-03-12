<?php

namespace Cine\App\Repository;

use Cine\App\Entity\Film;
use PDO;

class FilmRepository
{
    public function findAll()
    {
        $sql = "SELECT * FROM film";
        $pdo = new PDO('mysql:dbname=cine;host=mysql;charset=utf8', 'user', 'pwd');
        $request = $pdo->prepare($sql);
        $request->execute();
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);

        return $request->fetchAll();
    }

    public function findByGenre($genreId)
    {
        $sql = "SELECT * FROM film WHERE genre_id = :id";

        $pdo = new PDO('mysql:dbname=cine;host=mysql;charset=utf8', 'user', 'pwd');
        $request = $pdo->prepare($sql);
        $request->execute([
            'id' => $genreId
        ]);
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);

        return $request->fetchAll();
    }
}








   