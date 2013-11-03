<?php

namespace Sf2films\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sf2films\FilmsBundle\Entity\Content;

class PersonController extends Controller
{
    public function showAllPersonAction()
    {
        $data = '';
        return $this->render('Sf2filmsFilmsBundle:Default:person_all.html.twig', array('data' => $data));
    }

    public function showElementPersonAction()
    {
    }
}
