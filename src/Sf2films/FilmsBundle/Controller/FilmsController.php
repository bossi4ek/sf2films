<?php

namespace Sf2films\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sf2films\FilmsBundle\Entity\Content;

class FilmsController extends Controller
{
    public function showAllFilmsAction($page)
    {
        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig', array('page' => $page));
    }

    public function showElementFilmsAction()
    {
    }
}
