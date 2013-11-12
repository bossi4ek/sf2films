<?php

namespace Sf2films\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sf2films\FilmsBundle\Entity\Genre;
use Sf2films\FilmsBundle\Form\GenreType;

class GenreController extends Controller
{
    public function showAllAction()
    {
        $data = $this->getDoctrine()->getRepository('Sf2filmsFilmsBundle:Genre')->findAll();
        return $this->render('Sf2filmsFilmsBundle:Default:genre_all.html.twig', array('data' => $data));
    }

    public function showElementAction()
    {
    }

    public function addElementAction(Request $request)
    {
        $obj = new Genre();
        $form = $this->createForm(new GenreType(), $obj);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $obj->setNameTranslit($this->get('films.transliter')->getTranslit($obj->getName()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($obj);
            $em->flush();

            return $this->redirect($this->generateUrl('sf2films_films_genre'));
        }

        return $this->render('Sf2filmsFilmsBundle:Default:genre_add.html.twig', array(
                'form' => $form->createView())
        );
    }

    public function delElementAction($id) {
        $em = $this->getDoctrine()->getManager();
        $genre = $em->getRepository('Sf2filmsFilmsBundle:Genre')->findOneById($id);
        $em->remove($genre);
        $em->flush();

        return $this->redirect($this->generateUrl('sf2films_films_genre'));
    }
}
