<?php

namespace Cine\App\Repository;

use Cine\App\Entity\Film;
use PDO;

class FilmRepository
{

    private function getPDO(): PDO
    {
        return new PDO('mysql:dbname=cine;host=mysql;charset=utf8', 'user', 'pwd');
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM film";
        $request = $this->getPDO()->prepare($sql);
        $request->execute();
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);

        return $request->fetchAll();
    }

    
    public function findByGenre(int $genreId): array
    {
        $sql = "SELECT * FROM film WHERE genre_id = :id";
        
        $request = $this->getPDO()->prepare($sql);
        $request->execute(['id' => $genreId]);
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);

        return $request->fetchAll();
    }


    public function find(int $id)
    {
        $sql = "SELECT * FROM film WHERE id = :id";
        
        $request = $this->getPDO()->prepare($sql);
        $request->execute(['id' => $id]);
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);

        return $request->fetch(); 
    }





public function findNotCategorized(): array
{

    $sql = "SELECT * FROM film WHERE genre_id IS NULL"; 
    
    $request = $this->getPDO()->prepare($sql);
    $request->execute();
    $request->setFetchMode(PDO::FETCH_CLASS, Film::class);

    return $request->fetchAll();
}

public function findByStatus(int $status): array
{
    $sql = "SELECT * FROM film WHERE isWatched = :status";
    $request = $this->getPDO()->prepare($sql);
    $request->execute(['status' => $status]);
    $request->setFetchMode(PDO::FETCH_CLASS, Film::class);

    return $request->fetchAll();
}

public function delete (int $id)
{
   $sql = "delete from film where id =:id";
   $request = $this->getPDO()->prepare($sql);
   return  $request->execute(['id'=>$id]);


}
public function update(
    int $id,
    string $title,
    string $posterPath,
    string $releaseDate,
    int $runtime,
    string $overview,
    ?int $genreId,
    string $description,
    int $isWatched
)
{
    $sql = "UPDATE film 
            SET title = :title,
                poster_path = :poster_path,
                release_date = :release_date,
                runtime = :runtime,
                overview = :overview,
                genre_id = :genre_id,
                description = :description,
                isWatched = :isWatched
            WHERE id = :id";

    $request = $this->getPDO()->prepare($sql);

    return $request->execute([
        'id' => $id,
        'title' => $title,
        'poster_path' => $posterPath,
        'release_date' => $releaseDate,
        'runtime' => $runtime,
        'overview' => $overview,
        'genre_id' => $genreId,
        'description' => $description,
        'isWatched' => $isWatched,
    ]);
}

public function save(int $id, ?int $genreId, string $description, int $isWatched)
{
    $sql = "UPDATE film
            SET genre_id = :genre_id,
                description = :description,
                isWatched = :isWatched
            WHERE id = :id";

    $request = $this->getPDO()->prepare($sql);

    return $request->execute([
        'id' => $id,
        'genre_id' => $genreId,
        'description' => $description,
        'isWatched' => $isWatched,
    ]);
}






}
















   