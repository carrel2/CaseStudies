<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\HotSpotInfo;
use AppBundle\FileUploader;

class SoundUploadListener
{
    private $uploader;
    private $directory;

    public function __construct(FileUploader $uploader, $directory)
    {
        $this->uploader = $uploader;
        $this->directory = $directory;
    }

    public function prePersist(HotSpotInfo $info, LifecycleEventArgs $args)
    {
        $this->uploadFile($info);
    }

    public function preUpdate(HotSpotInfo $info, PreUpdateEventArgs $args)
    {
        $this->checkForSound($info, $args);
    }

    public function preRemove(HotSpotInfo $info, LifecycleEventArgs $args)
    {
      $this->removeUpload($info->getSound());
    }

    private function checkForSound($info, $args)
    {
      if( $args->hasChangedField('sound') && $args->getNewValue('sound') != null ) {
        $this->removeUpload($args->getOldValue('sound'));

        $this->uploadFile($info);
      }
    }

    private function uploadFile($info)
    {
        $file = $info->getSound();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file, $this->directory);
        $info->setSound($fileName);
    }

    private function removeUpload($file)
    {
      $filePath = "{$this->directory}/$file";

      if( file_exists($filePath) ) {
        unlink($filePath);
      }
    }
}
