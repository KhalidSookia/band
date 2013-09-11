<?php

namespace App\PictureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\AppBundle\Services\FileUpload\FileUpload;
use App\AppBundle\Services\Directory\Directory;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Picture
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\PictureBundle\Entity\PictureRepository")
 *
 * @Gedmo\Uploadable(pathMethod="getPath", callback="myCallbackMethod", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
*/

class Picture extends FileUpload
{
    public function __construct(){
        $date = new \DateTime();
        $this->uniqid = $date->format('Ymdhis');
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
    * @Gedmo\Slug(fields={"name"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;


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
     * Set uniqid
     *
     * @param string $uniqid
     * @return Picture
     */
    public function setUniqid($uniqid)
    {
        $this->uniqid = $uniqid;
    
        return $this;
    }

    /**
     * Get uniqid
     *
     * @return string 
     */
    public function getUniqid()
    {
        return $this->uniqid;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Picture
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
     * Set extension
     *
     * @param string $extension
     * @return Picture
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    
        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Picture
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}