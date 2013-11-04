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
        return $this->render('Sf2filmsFilmsBundle:Default:films_all.html.twig', array('page' => $page));
    }

    public function showElementAction()
    {
    }

    public function addElementAction(Request $request)
    {
        $content_obj = new Content();
        $form = $this->createForm(new FilmsType(), $content_obj);

        $form->handleRequest($request);

        if ($form->isValid()) {
//            if ($form->get('Отправить')->isClicked()) {
//            }


//            $post_obj = $form->getData();
//            $post_obj->setDatecreate(time());
//
//            //Если выбран checkbox (постим рандомное сообщение)
//            if ($post_obj->getRandmessage()) {
//                $post_obj->setMessage($this->container->get('my_randomer')->generateRandomString());
//            }
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($post_obj);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('sf2films_films_all'));
        }

        return $this->render('Sf2filmsFilmsBundle:Default:films_add.html.twig', array(
                'form' => $form->createView())
        );
    }
}
