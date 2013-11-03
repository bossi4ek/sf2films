<?php
/**
 * User: boss
 * Date: 03.11.13
 * Time: 12:34
 */

namespace Sf2films\FilmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="content")
 */
class Content {
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
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="integer")
     */
    protected $date_create;

    /**
     * @ORM\Column(type="integer")
     */
    protected $date_update;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $is_publish;

    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="contents")
     * @ORM\JoinTable(name="content_genres")
     **/
    private $genres;

    /**
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="contents")
     * @ORM\JoinTable(name="content_persons")
     **/
    private $persons;

    public function __construct() {
        $this->genres = new ArrayCollection();
        $this->persons = new ArrayCollection();
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
     * @return Content
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
     * Set name_translit
     *
     * @param string $nameTranslit
     * @return Content
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

    /**
     * Set description
     *
     * @param string $description
     * @return Content
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date_create
     *
     * @param integer $dateCreate
     * @return Content
     */
    public function setDateCreate($dateCreate)
    {
        $this->date_create = $dateCreate;
    
        return $this;
    }

    /**
     * Get date_create
     *
     * @return integer 
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * Set date_update
     *
     * @param integer $dateUpdate
     * @return Content
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->date_update = $dateUpdate;
    
        return $this;
    }

    /**
     * Get date_update
     *
     * @return integer 
     */
    public function getDateUpdate()
    {
        return $this->date_update;
    }

    /**
     * Set is_publish
     *
     * @param integer $isPublish
     * @return Content
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
     * Add genres
     *
     * @param \Sf2films\FilmsBundle\Entity\Genre $genres
     * @return Content
     */
    public function addGenre(\Sf2films\FilmsBundle\Entity\Genre $genres)
    {
        $this->genres[] = $genres;
    
        return $this;
    }

    /**
     * Remove genres
     *
     * @param \Sf2films\FilmsBundle\Entity\Genre $genres
     */
    public function removeGenre(\Sf2films\FilmsBundle\Entity\Genre $genres)
    {
        $this->genres->removeElement($genres);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Add persons
     *
     * @param \Sf2films\FilmsBundle\Entity\Person $persons
     * @return Content
     */
    public function addPerson(\Sf2films\FilmsBundle\Entity\Person $persons)
    {
        $this->persons[] = $persons;
    
        return $this;
    }

    /**
     * Remove persons
     *
     * @param \Sf2films\FilmsBundle\Entity\Person $persons
     */
    public function removePerson(\Sf2films\FilmsBundle\Entity\Person $persons)
    {
        $this->persons->removeElement($persons);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersons()
    {
        return $this->persons;
    }
}