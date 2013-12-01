<?php

namespace Sf2films\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sf2films\FilmsBundle\Entity\Person;
use Sf2films\FilmsBundle\Form\PersonType;

class PersonController extends Controller
{
    public function showAllAction()
    {
        $data = $this->getDoctrine()->getRepository('Sf2filmsFilmsBundle:Person')->findAll();
        return $this->render('Sf2filmsFilmsBundle:Default:person_all.html.twig', array('data' => $data));
    }

    public function showElementAction()
    {
    }

    public function editElementAction(Request $request)
    {
        $id = $request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('Sf2filmsFilmsBundle:Person')->findOneById($id);
        $form = $this->createForm(new PersonType(), $obj);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $obj->setNameTranslit($this->get('films.transliter')->getTranslit($obj->getName()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($obj);
            $em->flush();

            return $this->redirect($this->generateUrl('sf2films_films_person'));
        }

        return $this->render('Sf2filmsFilmsBundle:Default:person.html.twig', array(
                'form' => $form->createView())
        );
    }

    public function addElementAction(Request $request)
    {
        $obj = new Person();
        $form = $this->createForm(new PersonType(), $obj);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $obj->setNameTranslit($this->get('films.transliter')->getTranslit($obj->getName()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($obj);
            $em->flush();

            return $this->redirect($this->generateUrl('sf2films_films_person'));
        }

        return $this->render('Sf2filmsFilmsBundle:Default:person.html.twig', array(
                'form' => $form->createView())
        );
    }

    public function delElementAction($id) {
        $em = $this->getDoctrine()->getManager();
        $genre = $em->getRepository('Sf2filmsFilmsBundle:Person')->findOneById($id);
        $em->remove($genre);
        $em->flush();

        return $this->redirect($this->generateUrl('sf2films_films_person'));
    }
}
