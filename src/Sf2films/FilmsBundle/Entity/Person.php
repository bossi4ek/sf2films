<?php
/**
 * User: boss
 * Date: 03.11.13
 * Time: 12:54
 */

namespace Sf2films\FilmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person {
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
     * @ORM\Column(type="integer")
     */
    protected $date_birth;

    /**
     * @ORM\Column(type="integer")
     */
    protected $gender_code;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $is_publish;

    /**
     * ORM\@ManyToMany(targetEntity="Content", mappedBy="persons")
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
     * @return Person
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
     * Set date_birth
     *
     * @param integer $dateBirth
     * @return Person
     */
    public function setDateBirth($dateBirth)
    {
        $this->date_birth = $dateBirth;
    
        return $this;
    }

    /**
     * Get date_birth
     *
     * @return integer 
     */
    public function getDateBirth()
    {
        return $this->date_birth;
    }

    /**
     * Set is_publish
     *
     * @param integer $isPublish
     * @return Person
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
        return $this->is_publish == 1 ? true : false;
    }

    /**
     * Set name_translit
     *
     * @param string $nameTranslit
     * @return Person
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
     * Set gender_code
     *
     * @param integer $genderCode
     * @return Person
     */
    public function setGenderCode($genderCode)
    {
        $this->gender_code = $genderCode;
    
        return $this;
    }

    /**
     * Get gender_code
     *
     * @return integer 
     */
    public function getGenderCode()
    {
        return $this->gender_code;
    }
}