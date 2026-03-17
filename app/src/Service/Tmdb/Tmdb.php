<?php

namespace Cine\App\Service\Tmdb;

class Tmdb
{
    /** URL de base de l'API TMDB */
    const BASE_URL = "https://api.themoviedb.org/3";
    /** URL de base pour les affiches des films */
    const IMG_URL  = "https://image.tmdb.org/t/p/w300";


    public function getFilmByTmdbSearch(string $search)
    {
        return $this->tmdb_get('/search/movie', ['query' => $search]);
    }
  

    public function getFilmByTmdbId($id) : ?array
    {
        $data =  $this->tmdb_get('/movie/' . (int)$id);
        return empty($data) ? null : $data;


    }


    private function tmdb_get($endpoint, $params = []) 
    {
        global $API_KEY;
        $params['api_key']  = $API_KEY;
        $params['language'] = 'fr-FR';
        $url = self::BASE_URL . $endpoint . '?' . http_build_query($params);
        $response = file_get_contents($url);

        if($response === false) {
            return [];
        }
        $data = json_decode($response, true);
        return is_array ($data) ? $data : [];
    }



}