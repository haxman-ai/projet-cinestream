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

    /**
     * Gère l'affichage de la vidéothèque et les filtres 
     */
  public function index()
{
    // 1. Toujours récupérer les genres pour l'affichage en haut [cite: 32, 41]
    $genres = $this->genreRepository->findAll();
    $title = "Ma Vidéothèque";

    // 2. Récupérer l'ID de l'URL proprement 
    $genreId = $_GET['id'] ?? null;

    // 3. LA GARE DE TRIAGE (Ordre de priorité)
    if ($genreId) {
        // PRIORITÉ 1 : Si un ID existe, on filtre par genre [cite: 34, 38, 44]
        $films = $this->filmRepository->findByGenre((int)$genreId);

    } elseif (isset($_GET['notcategorie'])) {
        // FILTRE NC : On cherche les films sans genre (NULL)
        $films = $this->filmRepository->findNotCategorized();

    } elseif (isset($_GET['isWatched'])) {
        // FILTRE STATUT : Vu ou À voir
        $films = $this->filmRepository->findByStatus((int)$_GET['isWatched']);

    } else {
        // PAR DÉFAUT : On affiche tout si aucun filtre n'est actif [cite: 35, 43]
        $films = $this->filmRepository->findAll();
    }

    // 4. Envoyer à la vue [cite: 36]
    require_once __DIR__ . '/../view/index.phtml';
}


}











