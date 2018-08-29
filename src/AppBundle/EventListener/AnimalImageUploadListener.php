<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\Animal;
use AppBundle\FileUploader;

class AnimalImageUploadListener
{
    private $uploader;
    private $directory;

    public function __construct(FileUploader $uploader, $directory)
    {
        $this->uploader = $uploader;
        $this->directory = $directory;
    }

    public function prePersist(Animal $animal, LifecycleEventArgs $args)
    {
        $this->uploadFile($animal);
    }

    public function preUpdate(Animal $animal, PreUpdateEventArgs $args)
    {
        $this->checkForImage($animal, $args);
    }

    public function preRemove(Animal $animal, LifecycleEventArgs $args)
    {
      $this->removeUpload($animal->getImage());
    }

    private function checkForImage($animal, $args)
    {
      if( $args->hasChangedField('image') && $args->getNewValue('image') != null ) {
        $this->removeUpload($args->getOldValue('image'));

        $this->uploadFile($animal);
      } else {
        $args->setNewValue('image', $args->getOldValue('image'));
      }
    }

    private function uploadFile($animal)
    {
        $file = $animal->getImage();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file, $this->directory);
        $animal->setImage($fileName);
    }

    private function removeUpload($file)
    {
      $filePath = "{$this->directory}/$file";

      if( file_exists($filePath) ) {
        unlink($filePath);
      }
    }
}
