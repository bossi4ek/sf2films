<?php
/**
 * User: boss
 * Date: 03.11.13
 * Time: 12:52
 */

namespace Sf2films\FilmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="genre")
 */
class Genre {
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
    protected $name;

    /**
     * @ORM\Column()
     */
    protected $name_translit;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $is_publish;

    /**
     * ORM\@ManyToMany(targetEntity="Content", mappedBy="genres")
     **/
    private $contents;

    public function __construct() {
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
     * Set name
     *
     * @param string $name
     * @return Genre
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set is_publish
     *
     * @param integer $isPublish
     * @return Genre
     */
    public function setIsPublish($isPublish)
    {
        $this->is_publish = $isPublish;
    
        return $this;
    }

    /**
     * Get is_publish
     *
     * @return integer 
     */
    public function getIsPublish()
    {
        return $this->is_publish;
    }

    /**
     * Set name_translit
     *
     * @param string $nameTranslit
     * @return Genre
     */
    public function setNameTranslit($nameTranslit)
    {
        $this->name_translit = $nameTranslit;
    
        return $this;
    }

    /**
     * Get name_translit
     *
     * @return string 
     */
    public function getNameTranslit()
    {
        return $this->name_translit;
    }
}