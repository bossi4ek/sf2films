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
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="Sf2films\FilmsBundle\Repository\ContentRepository")
 * @ORM\Table(name="content")
 * @ORM\HasLifecycleCallbacks
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
     * @Assert\Length(min = "5", groups={"AddContent"})
     * @Assert\Length(min = "2", groups={"EditContent"})
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
     * @ORM\Column(type="smallint", options={"default" = 0})
     */
    protected $is_publish;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank(groups={"AddContent", "EditContent"})
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     message="Год состоит только с цыфр",
     *     groups={"AddContent", "EditContent"}
     * )
     */
    protected $year;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank(groups={"AddContent", "EditContent"})
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     message="Продолжительность состоит только с цыфр",
     *     groups={"AddContent", "EditContent"}
     * )
     */
    protected $duration;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(groups={"AddContent", "EditContent"})
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     message="Бюджет состоит только с цыфр",
     *     groups={"AddContent", "EditContent"}
     * )
     */
    protected $budget;

    protected $addinfo;

    /**
     * @var string $image
     *
     * @ORM\Column(name="poster_img", type="string", length=255, nullable=true)
     */
    protected $poster_img;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    private $temp;

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

    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="content", cascade={"persist"})
     **/
    private $tags;


    public function __construct() {
        $this->genres = new ArrayCollection();
        $this->persons = new ArrayCollection();
        $this->tags = new ArrayCollection();
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
//        $this->is_publish = $isPublish == false ? 0 : 1;
    
        return $this;
    }

    /**
     * Get is_publish
     *
     * @return integer 
     */
    public function getIsPublish()
    {
//        return $this->is_publish;
        return $this->is_publish == 1 ? true : false;
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

    /**
     * Set poster_img
     *
     * @param string $posterImg
     * @return Content
     */
    public function setPosterImg($posterImg)
    {
        $this->poster_img = $posterImg;
    
        return $this;
    }

    /**
     * Get poster_img
     *
     * @return string 
     */
    public function getPosterImg()
    {
        if (null === $this->poster_img) {
            return;
        }

        return $this->getWebPath();

//        return $this->poster_img;
    }


//    /**
//     * @Assert\File(maxSize="6000000")
//     */
//    private $file;
//
//    /**
//     * Sets file.
//     *
//     * @param UploadedFile $file
//     */
//    public function setFile(UploadedFile $file = null)
//    {
//        $this->file = $file;
//    }
//
//    /**
//     * Get file.
//     *
//     * @return UploadedFile
//     */
//    public function getFile()
//    {
//        return $this->file;
//    }
//
//    public function upload()
//    {
//        // the file property can be empty if the field is not required
//        if (null === $this->getFile()) {
//            return;
//        }
//
//        // use the original file name here but you should
//        // sanitize it at least to avoid any security issues
//
//        // move takes the target directory and then the
//        // target filename to move to
//        $this->getFile()->move(
//            $this->getUploadRootDir(),
//            $this->getFile()->getClientOriginalName()
//        );
//
//        // set the path property to the filename where you've saved the file
//        $this->poster_img = $this->getFile()->getClientOriginalName();
//
//        // clean up the file property as you won't need it anymore
//        $this->file = null;
//    }


//===================================================================================
//For uploads poster
//===================================================================================

    public function getAbsolutePath()
    {
        return null === $this->poster_img
            ? null
            : $this->getUploadRootDir().'/'.$this->poster_img;
    }

    public function getWebPath()
    {
        return null === $this->poster_img
            ? null
            : $this->getUploadDir().'/'.$this->poster_img;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return '/uploads/poster';
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->poster_img)) {
            // store the old name to delete after the update
            $this->temp = $this->poster_img;
            $this->poster_img = null;
        } else {
            $this->poster_img = 'initial';
        }
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->poster_img = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->poster_img);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
//===================================================================================


    /**
     * Set year
     *
     * @param integer $year
     * @return Content
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return Content
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    
        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set budget
     *
     * @param integer $budget
     * @return Content
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    
        return $this;
    }

    /**
     * Get budget
     *
     * @return integer 
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param mixed $addinfo
     */
    public function setAddinfo($addinfo)
    {
        $this->addinfo = $addinfo;
        $this->setYear($addinfo['year']);
        $this->setDuration($addinfo['duration']);
        $this->setBudget($addinfo['budget']);
    }

    /**
     * @return mixed
     */
    public function getAddinfo()
    {
        $addinfo['year'] = $this->getYear();
        $addinfo['duration'] = $this->getDuration();
        $addinfo['budget'] = $this->getBudget();
        $this->addinfo = $addinfo;
        return $this->addinfo;
    }

    /**
     * Add tags
     *
     * @param \Sf2films\FilmsBundle\Entity\Tag $tags
     * @return Content
     */
    public function addTag(\Sf2films\FilmsBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Sf2films\FilmsBundle\Entity\Tag $tags
     */
    public function removeTag(\Sf2films\FilmsBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}