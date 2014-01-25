<?php

namespace Sf2films\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo; // Подключение Gedmo

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column()
     * @Assert\Length(min = "2")
     */
    protected $txt;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="Sf2films\FilmsBundle\Entity\Content", inversedBy="comment")
     * @ORM\JoinColumn(name="id_content", referencedColumnName="id")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Sf2films\UserBundle\Entity\User", inversedBy="comment")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

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
     * Set txt
     *
     * @param string $txt
     * @return Comment
     */
    public function setTxt($txt)
    {
        $this->txt = $txt;
    
        return $this;
    }

    /**
     * Get txt
     *
     * @return string 
     */
    public function getTxt()
    {
        return $this->txt;
    }

    /**
     * Set content
     *
     * @param \Sf2films\FilmsBundle\Entity\Content $content
     * @return Comment
     */
    public function setContent(\Sf2films\FilmsBundle\Entity\Content $content = null)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return \Sf2films\FilmsBundle\Entity\Content 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set user
     *
     * @param \Sf2films\UserBundle\Entity\User $user
     * @return Comment
     */
    public function setUser(\Sf2films\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Sf2films\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Comment
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Comment
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}