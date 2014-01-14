<?php

namespace Sf2films\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
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

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->contents = new ArrayCollection();
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
}