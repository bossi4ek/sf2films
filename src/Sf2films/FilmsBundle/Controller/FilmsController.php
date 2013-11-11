<?php

namespace Sf2films\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sf2films\FilmsBundle\Entity\Content;
use Sf2films\FilmsBundle\Form\FilmsType;

class FilmsController extends Controller
{
    public function showAllAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('Sf2filmsFilmsBundle:Content')->findAllFilms();
        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig', array('data' => $data, 'page' => $page));
    }

    public function showElementAction($translit)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('Sf2filmsFilmsBundle:Content')->findOneByTranslit($translit);
        return $this->render('Sf2filmsFilmsBundle:Default:films_element.html.twig', array('data' => $data));
    }

    public function showAllByGenreAction($translit)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('Sf2filmsFilmsBundle:Content')->findAllByGenre($translit);
        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig', array('data' => $data));
    }

    public function showAllByPersonAction($translit)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('Sf2filmsFilmsBundle:Content')->findAllByPerson($translit);
        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig', array('data' => $data));
    }

    public function addElementAction(Request $request)
    {
        $content_obj = new Content();
        $form = $this->createForm(new FilmsType(), $content_obj);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $content_obj = $form->getData();
            $content_obj->setNameTranslit($this->get('films.transliter')->getTranslit($content_obj->getName()));
            $content_obj->setDateCreate(time());
            $content_obj->setDateUpdate(time());

            $em = $this->getDoctrine()->getManager();
            $em->persist($content_obj);
            $em->flush();

            return $this->redirect($this->generateUrl('sf2films_films_all'));
        }

        return $this->render('Sf2filmsFilmsBundle:Default:films_add.html.twig', array(
            'form' => $form->createView())
        );
    }

    public function delElementAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $genre = $em->getRepository('Sf2filmsFilmsBundle:Content')->findOneById($id);
        $em->remove($genre);
        $em->flush();

        return $this->redirect($this->generateUrl('sf2films_films_all'));
    }
}
