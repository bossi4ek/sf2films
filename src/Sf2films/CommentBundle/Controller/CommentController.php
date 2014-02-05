<?php

namespace Sf2films\CommentBundle\Controller;

use Sf2films\CommentBundle\Entity\Comment;
use Sf2films\CommentBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class CommentController extends Controller
{

    public function addElementAction(Request $request)
    {
        $comment = $request->request->get('comment');

        //find content
        $id_content = $request->attributes->get('id');
        $content = $this->getDoctrine()
            ->getRepository('Sf2filmsFilmsBundle:Content')
            ->findOneById($id_content);

        //find user
        $id_user = $this->getUser()->getId();
        $user_data = $this->getDoctrine()
            ->getRepository('Sf2filmsUserBundle:User')
            ->findOneById($id_user);

        //FIXME added validation commentForm
        if ($comment['txt'] != "") {
            //add new comment
            $obj = new Comment();
            $obj->setContent($content);
            $obj->setUser($user_data);
            $obj->setTxt($comment['txt']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($obj);
            $em->flush();

//----------------------------------------------------------------------------------------------------------------------
// creating the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($obj);
            $acl = $aclProvider->createAcl($objectIdentity);

// retrieving the security identity of the currently logged-in user
            $securityContext = $this->get('security.context');
            $user = $securityContext->getToken()->getUser();
            $securityIdentity = UserSecurityIdentity::fromAccount($user);

// grant owner access
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);
//----------------------------------------------------------------------------------------------------------------------
        }

        return $this->redirect($this->generateUrl('sf2films_films_element', array("slug" => $content->getSlug())));
    }

    public function editElementAction(Request $request)
    {
        $id = $request->attributes->get('id');

        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('Sf2filmsCommentBundle:Comment')->findOneById($id);

//----------------------------------------------------------------------------------------------------------------------
        $securityContext = $this->get('security.context');

// check for edit access
        if (false === $securityContext->isGranted('EDIT', $obj) && !$securityContext->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
//----------------------------------------------------------------------------------------------------------------------

        //content slug for redirect
        $content_slug = $obj->getContent()->getSlug();

        $form = $this->createForm(new CommentType(), $obj);

        $form->handleRequest($request);

        $comment_new = $request->request->get('comment');

//        if ($form->isValid()) {
        if ($comment_new['txt'] != "") {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('sf2films_films_element', array("slug" => $content_slug)));
        }

        return $this->render('Sf2filmsCommentBundle:Default:comment.html.twig', array(
                'form' => $form->createView())
        );
    }

    public function delElementAction(Request $request)
    {
        //find comment
        $id_comment = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('Sf2filmsCommentBundle:Comment')->findOneById($id_comment);

//----------------------------------------------------------------------------------------------------------------------
        $securityContext = $this->get('security.context');

// check for edit access
        if (false === $securityContext->isGranted('DELETE', $comment) && !$securityContext->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
//----------------------------------------------------------------------------------------------------------------------

        $em->remove($comment);
        $em->flush();

        //FIXME added delete ace
//        $aclProvider = $this->get('security.acl.provider');
//        $objectIdentity = ObjectIdentity::fromDomainObject($comment);

        return new Response(1);
    }
}
