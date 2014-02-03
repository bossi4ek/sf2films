<?php

namespace Sf2films\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sf2films\FilmsBundle\Entity\Content;
use Sf2films\FilmsBundle\Form\FilmsType;
use Sf2films\FilmsBundle\Event\SitemapEvent;
use Sf2films\FilmsBundle\Entity\Tag;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sf2films\CommentBundle\Form\CommentType;

class ContentController extends Controller
{

    public function getFilmsService()
    {
        return $this->get('films');
    }

    public function showAllAction(Request $request)
    {

//        $user = $this->getUser();
//        echo $user;

//Use Service

        if ($this->get('security.context')->isGranted('ROLE_ADMIN') === true) {
            $data = $this->getFilmsService()->showAllFilms();
        }
        else {
            $data = $this->getFilmsService()->showAllFilmsIsPublish();
        }

        $page = $request->get('page');

//        $adapter = new ArrayAdapter($data);
        $adapter = new DoctrineORMAdapter($data);

        $pagerfanta = new Pagerfanta($adapter);
        if(!$page) {
            $page = 1;
        }

        //500 Internal Server Error - OutOfRangeCurrentPageException
        //Page "2" does not exist. The currentPage must be inferior to "1"
//        try {
//            $pagerfanta->setCurrentPage($page);
//        } catch (NotValidCurrentPageException $e) {
//            throw new NotFoundHttpException();
//        }

        $pagerfanta->setMaxPerPage($this->container->getParameter('element_per_page'));
        $pagerfanta->setCurrentPage($page);
        $data = $pagerfanta->getCurrentPageResults();

        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig',
                              array(
                                  'data' => $data,
                                  'page' => $page,
                                  'pagerfanta' => $pagerfanta
                              ));

//Use Entity Repository
//        $em = $this->getDoctrine()->getManager();
//        $data = $em->getRepository('Sf2filmsFilmsBundle:Content')->findAllFilms();
//        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig', array('data' => $data, 'page' => $page));
    }

    public function showElementAction($slug)
    {
        $data = $this->getFilmsService()->findOneBySlug($slug);
//        var_dump($data);

        $comment_form = $this->createForm(new CommentType());

        return $this->render('Sf2filmsFilmsBundle:Default:films_element.html.twig',
                              array(
                                  'data' => $data,
                                  'comment_form' => $comment_form->createView()
                              ));
    }

    public function showAllByGenreAction($translit)
    {
        $data = $this->getFilmsService()->findAllByGenre($translit);

        $page = $this->getRequest()->get('page');

//        $adapter = new ArrayAdapter($data);
        $adapter = new DoctrineORMAdapter($data);

        $pagerfanta = new Pagerfanta($adapter);
        if(!$page) {
            $page = 1;
        }

        $pagerfanta->setMaxPerPage($this->container->getParameter('element_per_page'));
        $pagerfanta->setCurrentPage($page);
        $data = $pagerfanta->getCurrentPageResults();

        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig',
            array(
                'data' => $data,
                'page' => $page,
                'pagerfanta' => $pagerfanta
            ));

//        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig',
//                              array('data' => $this->getFilmsService()->findAllByGenre($translit)));
    }

    public function showAllByPersonAction($translit)
    {
        $data = $this->getFilmsService()->findAllByPerson($translit);

        $page = $this->getRequest()->get('page');

//        $adapter = new ArrayAdapter($data);
        $adapter = new DoctrineORMAdapter($data);

        $pagerfanta = new Pagerfanta($adapter);
        if(!$page) {
            $page = 1;
        }

        $pagerfanta->setMaxPerPage($this->container->getParameter('element_per_page'));
        $pagerfanta->setCurrentPage($page);
        $data = $pagerfanta->getCurrentPageResults();

        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig',
            array(
                'data' => $data,
                'page' => $page,
                'pagerfanta' => $pagerfanta
            ));

//        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig',
//                              array('data' => $this->getFilmsService()->findAllByPerson($translit)));
    }

    public function addElementAction(Request $request)
    {
        $content_obj = new Content();
        $form = $this->createForm(new FilmsType(), $content_obj, array("validation_groups" => array("AddContent")));

        $form->handleRequest($request);

        if ($form->isValid()) {

            $content_obj->setIsPublish($content_obj->getIsPublish() == false ? 0 : $content_obj->getIsPublish());

//            $content_obj->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($content_obj);
            $em->flush();

            return $this->redirect($this->generateUrl('sf2films_films_all'));
        }

        return $this->render('Sf2filmsFilmsBundle:Default:films.html.twig', array(
            'action' => $this->generateUrl('sf2films_films_add'),
            'content' => $content_obj,
            'form' => $form->createView())
        );
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
            //remove the relationship
            foreach ($originalTags as $tag) {
                if (false === $content_obj->getTags()->contains($tag)) {
                    //delete the Tag entirely
                    $em->remove($tag);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('sf2films_films_all'));
        }

        return $this->render('Sf2filmsFilmsBundle:Default:films.html.twig', array(
                'action' => $this->generateUrl('sf2films_films_edit', array('id' => $id)),
                'content' => $content_obj,
                'form' => $form->createView())
        );
    }

    public function delElementAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('Sf2filmsFilmsBundle:Content')->findOneById($id);
        $em->remove($content);
        //remove the relationship
        foreach ($content->getTags() as $tag) {
            //delete the Tag entirely
            $em->remove($tag);
        }
        $em->flush();

        //FIXME added delete comment ace

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
