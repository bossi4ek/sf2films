<?php

namespace Sf2films\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Sf2films\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Sf2films\FilmsBundle\Entity\Content", inversedBy="users")
     * @ORM\JoinTable(name="user_content")
     **/
    private $contents;

    /**
     * @ORM\OneToMany(targetEntity="Sf2films\CommentBundle\Entity\Comment", mappedBy="content")
     */
    protected $comments;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->contents = new ArrayCollection();

        $this->comments = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add contents
     *
     * @param \Sf2films\FilmsBundle\Entity\Content $contents
     * @return User
     */
    public function addContent(\Sf2films\FilmsBundle\Entity\Content $contents)
    {
        $this->contents[] = $contents;
    
        return $this;
    }

    /**
     * Remove contents
     *
     * @param \Sf2films\FilmsBundle\Entity\Content $contents
     */
    public function removeContent(\Sf2films\FilmsBundle\Entity\Content $contents)
    {
        $this->contents->removeElement($contents);
    }

    /**
     * Get contents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Add comments
     *
     * @param \Sf2films\CommentBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\Sf2films\CommentBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Sf2films\CommentBundle\Entity\Comment $comments
     */
    public function removeComment(\Sf2films\CommentBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}