<?php

namespace App\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\AppBundle\Services\Directory\Directory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Upload
 *
 * @ORM\MappedSuperclass
 *
 * @ORM\HasLifecycleCallbacks
 *
 * @Gedmo\Uploadable(pathMethod="getUserRootDir", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 */
abstract class Upload extends Directory
{
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
     * @ORM\Column(name="original_name", type="string", length=255)
     */
    private $originalName;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @Gedmo\slug(fields={"originalName"})
     *
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;


    /**
     * @ORM\Column(name="path", type="string")
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @Assert\File(maxSize="60000000")
     */
    private $file;


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
     * Set originalName
     *
     * @param string $originalName
     * @return Upload
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
    
        return $this;
    }

    /**
     * Get originalName
     *
     * @return string 
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set extension
     *
     * @param string $extension
     * @return Upload
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
     * Set path
     *
     * @param string $path
     * @return Upload
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Upload
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

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        if(isset($this->path)){
            $this->tempFileName = $this->path;

            $this->path = null;
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    // My functions

    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */

    public function preUpload(){
        if(null === $this->file){
            return;
        }else{
            $this->extension = $this->file->guessExtension();
            $this->originalName = $this->file->getClientOriginalName();
            $this->path = $this->getUserRootDir();
        }
    }

    /**
    * @ORM\PostPersist()
    */
    public function upload(){
        if(null === $this->file){
            return;
        }
        if(null !== $this->tempFileName){
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFileName;
            if(file_exists($oldFile)){
                unlink($oldFile);
            }
        }
        $this->file->move($getUserRootDir(), $this->id.'.'.$this->extension);
    }

    /**
    * @ORM\PreRemove()
    */
    public function preRemoveUpload(){
        $this->tempFileName = $this->getUploadRootDir().'/'.$this->id.'.'.$this->extension;
    }

    /**
    * @ORM\PostRemove()
    */
    public function removeUpload(){
        if(file_exists($this->tempFileName)){
            unlink($this->tempFileName);
        }
    }
}