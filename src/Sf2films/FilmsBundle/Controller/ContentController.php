<?php

namespace Sf2films\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sf2films\FilmsBundle\Entity\Content;
use Sf2films\FilmsBundle\Form\FilmsType;
use Sf2films\FilmsBundle\Event\SitemapEvent;
//use Sf2films\FilmsBundle\Films;

class ContentController extends Controller
{

    public function getFilmsService()
    {
        return $this->get('films');
    }

    public function showAllAction($page)
    {

//Use Service
        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig',
                              array('data' => $this->getFilmsService()->showAllFilms(), 'page' => $page));

//Use Entity Repository
//        $em = $this->getDoctrine()->getManager();
//        $data = $em->getRepository('Sf2filmsFilmsBundle:Content')->findAllFilms();
//        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig', array('data' => $data, 'page' => $page));
    }

    public function showElementAction($translit)
    {

        return $this->render('Sf2filmsFilmsBundle:Default:films_element.html.twig',
                              array('data' => $this->getFilmsService()->findOneByTranslit($translit)));
    }

    public function showAllByGenreAction($translit)
    {
        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig',
                              array('data' => $this->getFilmsService()->findAllByGenre($translit)));
    }

    public function showAllByPersonAction($translit)
    {
        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig',
                              array('data' => $this->getFilmsService()->findAllByPerson($translit)));
    }

    public function editElementAction(Request $request)
    {
        $id = $request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        $content_obj = $em->getRepository('Sf2filmsFilmsBundle:Content')->findOneById($id);


        $originalTags = array();
        if ($content_obj->getTags() != null) {
            // Create an array of the current Tag objects in the database
            foreach ($content_obj->getTags() as $tag) $originalTags[] = $tag;
        }

        $form = $this->createForm(new FilmsType(), $content_obj, array("validation_groups" => array("EditContent")));

        $form->handleRequest($request);

        if ($form->isValid()) {

//            var_dump($content_obj->getIsPublish());
//            exit;

            // filter $originalTags to contain tags no longer present
            foreach ($content_obj->getTags() as $tag) {
                foreach ($originalTags as $key => $toDel) {
                    if ($toDel->getId() === $tag->getId()) {
                        unset($originalTags[$key]);
                    }
                }
            }

            $content_obj->setNameTranslit($this->get('films.transliter')->getTranslit($content_obj->getName()));
            $content_obj->setDateUpdate(time());

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('sf2films_films_all'));
        }

        return $this->render('Sf2filmsFilmsBundle:Default:films.html.twig', array(
                'action' => $this->generateUrl('sf2films_films_edit', array('id' => $id)),
                'form' => $form->createView())
        );
    }

    public function addElementAction(Request $request)
    {
        $content_obj = new Content();
        $form = $this->createForm(new FilmsType(), $content_obj, array("validation_groups" => array("AddContent")));

        $form->handleRequest($request);

        if ($form->isValid()) {

//            var_dump($content_obj->getIsPublish());
//            exit;


            $content_obj->setIsPublish($content_obj->getIsPublish() == false ? 0 : $content_obj->getIsPublish());

            $content_obj->setNameTranslit($this->get('films.transliter')->getTranslit($content_obj->getName()));
            $content_obj->setDateCreate(time());
            $content_obj->setDateUpdate(time());
//            $content_obj->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($content_obj);
            $em->flush();

            return $this->redirect($this->generateUrl('sf2films_films_all'));
        }

        return $this->render('Sf2filmsFilmsBundle:Default:films.html.twig', array(
            'action' => $this->generateUrl('sf2films_films_add'),
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

    public function showSiteMapAction()
    {
        $event = new SitemapEvent();
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch('sf2films_films.events.sitemap', $event);

        // Render sitemap.xml
        return $this->render('Sf2filmsFilmsBundle:Default:sitemap.xml.twig', array(
            'pages' => $event->getPages(),
        ));
    }
}
