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
        // CORRECTION ICI : 
        // On récupère la valeur. Si elle est vide ou égale à "0", on met null.
        $genreId = $_POST['genre_id'] ?? null;
        if ($genreId === "" || $genreId == 0) {
            $genreId = null;
        } else {
            $genreId = (int) $genreId;
        }

        $description = $_POST['description'] ?? '';
        $isWatched = (int) ($_POST['isWatched'] ?? 0);

        // On passe maintenant $genreId qui vaut soit un ID valide, soit null
        $this->filmRepository->update($id, $genreId, $description, $isWatched);

        header('Location: index.php?route=show&id=' . $id);
        exit;
    }

    $genres = $this->genreRepository->findAll();
    require __DIR__ . '/../view/update.phtml';
}

public function search(): void
{
    $query = ($_GET['query'] ?? '');
    $results = [];

    if ($query !== '') {
        $tmdb = new \Cine\App\Service\Tmdb\Tmdb();
        $data = $tmdb->getFilmByTmdbSearch($query);
        $results = $data['results'] ?? [];
    }

    require __DIR__ . '/../view/search.phtml';
}
public function showTmdb(): void
{
    $tmdbId = (int)($_GET['tmdb_id'] ?? 0);

    if ($tmdbId <= 0) {
        echo "Film introuvable";
        return;
    }

    $tmdb = new \Cine\App\Service\Tmdb\Tmdb();
    $film = $tmdb->getFilmByTmdbId($tmdbId);

    if (empty($film)) {
        echo "Film introuvable";
        return;
    }

    require __DIR__ . '/../view/showTmdb.phtml';
}




    public function add(): void
    {
        $tmdbid = (int)($_GET['tmdb_id'] ?? 0);

        if ($tmdbid <= 0) {
            echo 'film introuvable';
            return;
        }

        $tmdb = new \Cine\App\Service\Tmdb\Tmdb();
        $filmdata = $tmdb->getFilmByTmdbId($tmdbid);

        if (empty($filmdata)) {
            echo 'film introuvable';
            return;
        }

        $existingfilm = $this->filmRepository->findByTmdbId($tmdbid);

        if ($existingfilm) {
            header('Location: index.php?route=update&id=' . $existingfilm->getId());
            exit;
        }

        $newfilmid = $this->filmRepository->insertFromTmdb($filmdata);

        header('Location: index.php?route=update&id=' . $newfilmid);
        exit;
    }

}