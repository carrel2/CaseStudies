<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\HotSpotInfo;
use AppBundle\FileUploader;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class SoundUploadListener
{
    private $uploader;
    private $directory;
    private $logger;

    public function __construct(FileUploader $uploader, $directory, LoggerInterface $logger)
    {
        $this->uploader = $uploader;
        $this->directory = $directory;
        $this->logger = $logger;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if( !$entity instanceof HotSpotInfo ) {
          return;
        }

        if( $entity->hasSound() ) {
          $this->removeUpload($entity);
        }
        
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        // if( !empty($args->getEntityChangeSet()) ) {
        //   $this->checkForSound($args);
        // }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
      $entity = $args->getEntity();

      $this->removeUpload($entity);
    }

    private function checkForSound($args)
    {
      $entity = $args->getEntity();

      if( !$entity instanceof HotSpotInfo ) {
        return;
      }

      if( $args->hasChangedField('sound') && $args->getNewValue('sound') != null ) {
        $this->removeUpload($args->getOldValue('sound'));

        $this->uploadFile($entity);
      } else {
        $args->setNewValue('sound', $args->getOldValue('sound'));
      }
    }

    private function uploadFile($entity)
    {
        // upload only works for HotSpotInfo entities
        if (!$entity instanceof HotSpotInfo) {
            return;
        }

        $file = $entity->getSound();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file, $this->directory);
        $entity->setSound($fileName);
    }

    private function removeUpload($entity)
    {
      if( !$entity instanceof HotSpotInfo ) {
        return;
      }

      $file = $entity->getSound();

      $filePath = "{$this->directory}/$file";

      if( file_exists($filePath) ) {
        unlink($filePath);
      }
    }
}
