<?php

namespace Cine\App\Controller;

use Cine\App\Repository\FilmRepository;
use Cine\App\Repository\GenreRepository;
use Cine\App\Service\Tmdb\Tmdb;

class FilmController
{
    private $filmRepository;
    private $genreRepository;

    public function __construct()
    {
        $this->filmRepository = new FilmRepository();
        $this->genreRepository = new GenreRepository();
    }

    public function index()
    {
        $genres = $this->genreRepository->findAll();
        $title = "Ma Vidéothèque";
        $genreId = $_GET['id'] ?? null;

        if ($genreId) {
            $films = $this->filmRepository->findByGenre((int)$genreId);
        } elseif (isset($_GET['notcategorie'])) {
            $films = $this->filmRepository->findNotCategorized();
        } elseif (isset($_GET['isWatched'])) {
            $films = $this->filmRepository->findByStatus((int)$_GET['isWatched']);
        } else {
            $films = $this->filmRepository->findAll();
        }

        require_once __DIR__ . '/../view/index.phtml';
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $film = $this->filmRepository->find($id);

            if ($film) {
                require_once __DIR__ . '/../view/show.phtml';
                return;
            }
        }

        header('Location: index.php');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->filmRepository->delete($id);
        }

        header('Location: index.php');
        exit;
    }


 public function update()
{
    $id = (int) ($_GET['id'] ?? 0);

    if (!$id) {
        header('Location: index.php');
        exit;
    }

    $film = $this->filmRepository->find($id);

    if (!$film) {
        header('Location: index.php');
        exit;
    }

    if (!empty($_POST)) {
        $genreId = (int) ($_POST['genre_id'] ?? 0);
        $description = $_POST['description'] ?? '';
        $isWatched = (int) ($_POST['isWatched'] ?? 0);

        $this->filmRepository->update($id, $genreId, $description, $isWatched);

        header('Location: index.php?route=show&id=' . $id);
        exit;
    }

    $genres = $this->genreRepository->findAll();

    require __DIR__ . '/../view/update.phtml';
}



public function search()
{ 
    $query = ($_GET['query'] ??'');
    $results = [];

    if($query !=='') {
        $tmdb = new Tmdb();
        $results = $tmdb->getFilmbyTmdbsearch($query);

    }

     require __dir__ . ' /../view/search.phtml';

}

public function showTmdb()
{
   $tmdbid = $_GET['tmdb_id'] ?? null;
      
       if (!$tmdbid) {
        echo "film TMDB introuvable";

         return;
       }
    
       $tmdb = new Tmdb();
       $film = $tmdb->getFilmByTmdbId((int) $tmdbid);

       require __DIR__ . '/../view/showTmdb .phtml';
}




public function add ()

{
    $tmdbid = $_GET['tmdb_id'] ?? null;

    if (!$tmdbid) {
        echo "identifiant TMDB manquant";
        return;
    }
     
    if ($this->filmRepository->findbyTmdbid ((int) $tmdbid)) {
        echo "ce film est déja dans la vidéothéque";
        return;
    }

    $tmdb = new Tmdb();
    $film = $tmdb->getFilmByTmdbId((int) $tmdbid);

    $newId = $this->filmRepository->insertFromTmdb($film);

    header ('location:index.php?route=update&id=' . $newId);
  

    




}

}