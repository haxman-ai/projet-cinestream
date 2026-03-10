<?php

namespace Cine\App\Controller;

use Cine\App\Repository\GenreRepository; 

class FilmController
{
    
    private $GenreRepository;

    
    public function __construct(GenreRepository $GenreRepository)
    {
      
        $this->GenreRepository = $GenreRepository;
    }



   public function index()
{
    
    $films = $this->GenreRepository->findAll();
    
    $title = "Ma Vidéothèque";

    
    require_once __DIR__ . '/../view/index.phtml';
}
    









} 