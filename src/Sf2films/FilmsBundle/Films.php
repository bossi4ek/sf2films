<?php

namespace Sf2films\FilmsBundle;

use Sf2films\FilmsBundle\Repository\ContentRepository;

class Films {

    private $repo;

    function __construct(ContentRepository $repo)
    {
        $this->repo = $repo;
    }

//Get all films
    public function showAllFilms(){
        return $this->repo->findAllFilms();
    }

//Get one Element by slug
    public function findOneBySlug($slug){
        return $this->repo->findOneBySlug($slug);
    }

//Get films by genre
    public function findAllByGenre($translit){
        return $this->repo->findAllByGenre($translit);
    }

//Get films by person
    public function findAllByPerson($translit){
        return $this->repo->findAllByPerson($translit);
    }
}