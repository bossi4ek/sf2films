<?php

namespace Sf2films\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sf2films\FilmsBundle\Entity\Content;

class GenreController extends Controller
{
    public function showAllGenreAction()
    {
        $data = '';
        return $this->render('Sf2filmsFilmsBundle:Default:genre_all.html.twig', array('data' => $data));
    }

    public function showElementGenreAction()
    {
    }
}
