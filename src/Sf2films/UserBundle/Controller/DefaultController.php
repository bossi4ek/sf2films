<?php

namespace Sf2films\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('Sf2filmsUserBundle:Security:login.html.twig', array('name' => $name));
    }
}
