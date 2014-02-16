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
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    protected $firstname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    protected $lastname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=50)
     */
    protected $facebookId = '';

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

    public function serialize()
    {
        return serialize(array($this->facebookId, parent::serialize()));
    }

    public function unserialize($data)
    {
        list($this->facebookId, $parentData) = unserialize($data);
        parent::unserialize($parentData);
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
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * @param string $facebookId
     * @return void
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        $this->setUsername($facebookId);
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param Array
     */
    public function setFBData($fbdata)
    {
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
            $this->addRole('ROLE_FACEBOOK');
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstname($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastname($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
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