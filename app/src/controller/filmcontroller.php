<?php

namespace Cine\App\Controller;

use Cine\App\Repository\FilmRepository;
use Cine\App\Repository\GenreRepository;

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
    // 1. On récupère l'id du film depuis l'URL (ex: index.php?action=show&id=1)
    $id = $_GET['id'] ?? null;

    if ($id) {
        // 2. On demande au repository d'aller chercher CE film
        $film = $this->filmRepository->find($id);

        // 3. On vérifie si le film existe bien en base de données
        if ($film) {
            $title = $film->gettitle(); // Pour l'onglet du navigateur
            require_once __DIR__ . '/../view/show.phtml';
        } else {
            // Si l'ID n'existe pas, on peut rediriger ou afficher une erreur
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }
}
 public function delete()
{

$id = $_GET['id'] ?? null;

if ($id) {
    $this->filmRepository->delete($id);
}

header('location:index.php');

}


}











