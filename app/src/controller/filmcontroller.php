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

    $genres = $this->genreRepository->findAll();

    require __DIR__ . '/../view/update.phtml';
}

public function save()
{
    if (
        !empty($_POST['id']) &&
        isset($_POST['genre_id']) &&
        isset($_POST['description']) &&
        isset($_POST['isWatched'])
    ) {
        $id = (int) $_POST['id'];
        $genreId = $_POST['genre_id'] !== '' ? (int) $_POST['genre_id'] : null;
        $description = trim($_POST['description']);
        $isWatched = (int) $_POST['isWatched'];

        $this->filmRepository->save(
            $id,
            $genreId,
            $description,
            $isWatched
        );

        header('Location: index.php?route=show&id=' . $id . '&success=updated');
        exit;
    }

    echo "Données du formulaire manquantes.";
}



}