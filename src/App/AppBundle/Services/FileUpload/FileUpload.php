<?php

namespace App\AppBundle\Services\FileUpload;

use App\PictureBundle\Entity\Picture;
use App\AppBundle\Services\Directory\Directory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Gedmo\Uploadable(pathMethod="getPath")
*/

class FileUpload
{

    /**
     * @ORM\Column(name="path", type="string")
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @ORM\Column(name="mime_type", type="string")
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;

}