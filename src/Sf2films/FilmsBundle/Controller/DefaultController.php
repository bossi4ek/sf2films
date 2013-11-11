<?php

namespace Sf2films\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sf2films\FilmsBundle\Entity\Content;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('Sf2filmsFilmsBundle:Default:index.html.twig');
    }
}
