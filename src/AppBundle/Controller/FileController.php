<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Port\Excel\ExcelReader;
use AppBundle\Entity\Test;
use AppBundle\Entity\Medication;

class FileController extends Controller
{
  /**
   * @Route("/admin/import", name="import")
   */
  public function fileAction(Request $r)
  {
    $reader = null;
    $em = $this->getDoctrine()->getManager();

    $form = $this->createFormBuilder()
      ->add('type', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
        'choices' => array('Diagnostic procedures' => 'Test', 'Therapeutic procedures' => 'Medication'),
        'choices_as_values' => true,
      ))
      ->add('file', 'Symfony\Component\Form\Extension\Core\Type\FileType', array(
        'attr' => array(
          'accept' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ),
      ))
      ->add('sheet', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
        'required' => false,
        'empty_data' => -1,
        'attr' => array(
          'pattern' => '^[1-9][0-9]*',
          'title' => 'The specific sheet to import data from',
        ),
      ))
      ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
        'attr' => array(
          'class' => 'button',
        )
      ))
      ->getForm();

    $form->handleRequest($r);

    if( $form->isSubmitted() && $form->isValid() )
    {
      $importCount = 0;
      $updateCount = 0;
      $type = $form->getData()['type'];
      $file = $form->getData()['file'];
      $sheet = $form->getData()['sheet'];

      $class = "AppBundle\\Entity\\$type";

      if( $sheet < 0 ) {
        try {
          $i = 0;

          while (true) {
            $reader = new ExcelReader(new \SplFileObject($file->getRealPath()), 0, $i++);

            foreach ($reader as $row) {
              $row = array_change_key_case($row);
              $obj = $em->getRepository("AppBundle:$type")->findOneByName($row['name']);

              if( $row['name'] !== null && !$obj ) {
                $importCount++;
                $em->persist( new $class($row) );
              } elseif( $row['name'] !== null && $obj ) {
                $obj->setName($row['name']);
                $row['cost'] !== null ? $obj->setCost($row['cost']) : '';
                $row['group'] !== null ? $obj->setDGroup($row['group']) : '';
                $row['wait time'] !== null ? $obj->setWaitTime($row['wait time']) : '';
                $row['default result'] ? $obj->setDefaultResult($row['default result']) : '';

                $updateCount++;
              }
            }
          }
        } catch( \PHPExcel_Exception $e ) {
          if( $importCount ) {
            $this->addFlash('success', "Imported $importCount " . ngettext($type == "Medication" ? "Therapeutic procedure" : "Diagnostic procedure",$type == "Medication" ? "Therapeutic procedures" : "Diagnostic procedures", $importCount) . "!");
          }

          if( $updateCount ) {
            $this->addFlash('success', "Updated $updateCount " . ngettext($type == "Medication" ? "Therapeutic procedure" : "Diagnostic procedure",$type == "Medication" ? "Therapeutic procedures" : "Diagnostic procedures", $updateCount) . "!");
          }
        }
      }
      else {
        try {
            $reader = new ExcelReader(new \SplFileObject($file->getRealPath()), 0, $sheet);

            foreach ($reader as $row) {
              $row = array_change_key_case($row);
              $obj = $em->getRepository("AppBundle:$type")->findOneByName($row['name']);

              if( $row['name'] !== null && !$obj ) {
                $importCount++;
                $em->persist( new $class($row) );
              } elseif( $row['name'] !== null && $obj ) {
                $obj->setName($row['name']);
                $row['cost'] !== null ? $obj->setCost($row['cost']) : '';
                $row['group'] !== null ? $obj->setDGroup($row['group']) : '';
                $row['wait time'] !== null ? $obj->setWaitTime($row['wait time']) : '';
                $row['default result'] ? $obj->setDefaultResult($row['default result']) : '';

                $updateCount++;
              }
            }

            if( $importCount ) {
              $this->addFlash('success', "Imported $importCount " . ngettext($type == "Medication" ? "Therapeutic procedure" : "Diagnostic procedure",$type == "Medication" ? "Therapeutic procedures" : "Diagnostic procedures", $importCount) . "!");
            }

            if( $updateCount ) {
              $this->addFlash('success', "Updated $updateCount " . ngettext($type == "Medication" ? "Therapeutic procedure" : "Diagnostic procedure",$type == "Medication" ? "Therapeutic procedures" : "Diagnostic procedures", $updateCount) . "!");
            }
          } catch( \PHPExcel_Exception $e ) {
            $this->addFlash('error', 'Invalid sheet number');
          }
      }

      $em->flush();
    }

    return $this->render('Admin/import.html.twig', array(
      'form' => $form->createView(),
      'reader' => $reader,
    ));
  }
}
