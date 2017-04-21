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

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if( $args->hasChangedField('image') ) {
          $this->removeUpload($args->getOldValue('image'));
        }

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Animal entities
        if (!$entity instanceof Animal) {
            return;
        }

        $file = $entity->getImage();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setImage($fileName);
    }

    private function removeUpload($file)
    {
      unlink($this->uploader->getTargetDir() . '/' . $file);
    }
}
