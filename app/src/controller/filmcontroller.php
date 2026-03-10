<?php

namespace Cine\App\Controller;

use Cine\App\Repository\FilmRepository; 

class FilmController
{
    
    private $filmRepository;

    
    public function __construct(FilmRepository $filmRepository)
    {
        $this->filmRepository = new FilmRepository;
    }

   public function index()
{
    
    $films = $this->filmRepository->findAll();
  

    $title = " Vidéothèque";

    
    require_once __DIR__ . '/../view/index.phtml';
}
    

public function add()
{
    $films = $this->filmRepository->findById();

    $title = 'recherche';



    require_once __DIR__ . '/../view/index.phtml';






}

public function show()
{
    $id = $_GET['id'] ?? null;

    if($id) {
      
     $film = $this->filmRepository->find($id);

     if($film) {
        $title = $film['title'];
        require_once __DIR__ . '/../view/show.phtml';
     } else {
        header ('location:index.php');
        
     }






    }





}







} 
