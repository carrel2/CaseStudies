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
    private $logger;

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
        $this->checkForImage($args);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
      $entity = $args->getEntity();

      $this->removeUpload($entity);
    }

    private function checkForImage($args)
    {
      $entity = $args->getEntity();

      if( !$entity instanceof Animal ) {
        return;
      }

      if( $args->hasChangedField('image') && $args->getNewValue('image') != null ) {
        $this->removeUpload($args->getOldValue('image'));

        $this->uploadFile($entity);
      } else {
        $args->setNewValue('image', $args->getOldValue('image'));
      }
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

    private function removeUpload($entity)
    {
      if( !$entity instanceof Animal ) {
        return;
      }

      $file = $entity->getImage();

      $filePath = "{$this->uploader->getTargetDir()}/$file";

      if( file_exists($filePath) ) {
        unlink($filePath);
      }
    }
}
