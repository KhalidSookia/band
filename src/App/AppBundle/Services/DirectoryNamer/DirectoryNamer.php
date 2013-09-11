<?php

namespace App\BandBundle\Services\DirectoryNamer;

use App\UserBundle\Entity\User;

/*
* DirectoryNamer class
* @ORM\MappedSuperClass
*/

class DirectoryNamer{

    protected $context;


    public function __construct($context)
    {
        $this->context = $context;
    }

    /**
     * Get user id
     *
     * @return int $id
     */
    public function getUserId()
    {
        return $this->context->getToken()->getUser()->getId();
    }


    /**
     * Get User Root Dir
     *
     * @return string
     */
    public function getUserRootDir()
    {
        return $this->getUploadRootDir().$this->getUserId();
    }


    /**
     * Get upload dir
     *
     * @return string
     */
    public function getUploadDir()
    {
        return 'uploads/';
    }


    /**
     * Get upload root dir
     *
     * @return string
     */
    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    /**
     * Create user folders
     *
     * $folder is the folder which will contain all the picture uploads of
     *  the user.
     * $mainPictureFolder will contain the user's profile picture
     *
     */
    public function createUserFoldersIfNotExist()
    {
        $folder = $this->getUserRootDir();

        if ( ! is_dir($folder)) {
            if (mkdir($folder, 0777, true)) {
                mkdir($folder . '/mainPictureFolder', 0777, true);
            }
        }
    }



    /**
     * Get Name
     *
     * @return string
     */
    public function getName() //s/ Why this method ???
    {
        return 'AppDirectoyryNamer';
    }


    /**
     * Set locale
     *
     * @param ?? $locale
     */
    public function setLocale($locale) //s/ Why this method ??
    {
        $this->locale = $locale;
    }
}
