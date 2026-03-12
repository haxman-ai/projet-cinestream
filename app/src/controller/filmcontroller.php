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

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $films = $this->filmRepository->findByGenre($_GET['id']);
        } else {
            $films = $this->filmRepository->findAll();
        }

        require_once __DIR__ . '/../view/index.phtml';
    }

    public function findBygenre()
    {
        $id = $this->genreRepository->findBygenre();

        if (isset($_GET['id'])) {
            $genres = $this->genreRepository->findByid($_GET['id']);
        } else {
            $genres = $this->genreRepository->findAll();
        }
            }


        public function getiswatched() {
            $films = $filmRepository->findAll();

            if (isset($_GET['notcategorie'])) {
                $films = $filmRepository->getIsWatched();
            }

            if (isset($_GET['isWatched'])) {
                $films = $filmRepository->findBy(['isWatched' => $_GET['isWatched']]);
            }
        }







} 







