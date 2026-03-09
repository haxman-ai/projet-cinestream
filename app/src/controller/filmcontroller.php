<?php

namespace Cine\App\Controller;

use Cine\App\Repository\FilmRepository; 

class FilmController
{
    
    private $filmRepository;

    
    public function __construct(FilmRepository $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

   public function index()
{
    
    $films = $this->filmRepository->findAll();
    
    $title = "Ma Vidéothèque";

    
    require_once __DIR__ . '/../view/index.phtml';
}
    

} 