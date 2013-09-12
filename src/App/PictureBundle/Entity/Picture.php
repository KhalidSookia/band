<?php

namespace App\PictureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\UploadBundle\Entity\Upload;

/**
 * Picture
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\PictureBundle\Entity\PictureRepository")
 *
*/

class Picture extends Upload
{
    public function __construct(){
        
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
    * @ORM\ManyToOne(targetEntity="App\PictureBundle\Entity\Collection", cascade={"persist"})
    */
    private $collection;

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
     * Set collection
     *
     * @param \App\PictureBundle\Entity\Collection $collection
     * @return Picture
     */
    public function setCollection(\App\PictureBundle\Entity\Collection $collection = null)
    {
        $this->collection = $collection;
    
        return $this;
    }

    /**
     * Get collection
     *
     * @return \App\PictureBundle\Entity\Collection 
     */
    public function getCollection()
    {
        return $this->collection;
    }
}