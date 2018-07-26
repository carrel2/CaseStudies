<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Port\Excel\ExcelReader;
use AppBundle\Entity\DiagnosticProcedure;
use AppBundle\Entity\TherapeuticProcedure;

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
        'choices' => array('Diagnostic procedures' => 'DiagnosticProcedure', 'Therapeutic procedures' => 'TherapeuticProcedure'),
        'choices_as_values' => true,
        'label_attr' => array(
          'class' => 'is-large',
        )
      ))
      ->add('file', 'Symfony\Component\Form\Extension\Core\Type\FileType', array(
        'attr' => array(
          'accept' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ),
        'label_attr' => array(
          'class' => 'is-large asterisk',
        ),
      ))
      ->add('sheet', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
        'required' => false,
        'empty_data' => -1,
        'attr' => array(
          'pattern' => '^[1-9][0-9]*',
          'title' => 'The specific sheet to import data from',
        ),
        'label_attr' => array(
          'class' => 'is-large',
        )
      ))
      ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
        'attr' => array(
          'class' => 'button',
          'style' => 'margin-top: 1rem;',
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
      $sheet = $form->getData()['sheet'] - 1;

      $class = "AppBundle\\Entity\\$type";

      if( $sheet < 0 ) {
        try {
          $i = 0;

          while (true) {
            $reader = new ExcelReader(new \SplFileObject($file->getRealPath()), 0, $i++);

            foreach ($reader as $row) {
              $obj = $em->getRepository("AppBundle:$type")->findOneByName($row['Name']);

              if( !$obj && $row['Name'] ) {
                $importCount++;
                $em->persist( $class::createFromArray($row) );
              } elseif( $row['Name'] ) {
                $obj->updateFromArray($row);

                $updateCount++;
              }
            }
          }
        } catch( \PHPExcel_Exception $e ) {
          if( $importCount ) {
            $this->addFlash('success', "Imported $importCount " . ngettext($type == "TherapeuticProcedure" ? "Therapeutic procedure" : "Diagnostic procedure",$type == "TherapeuticProcedure" ? "Therapeutic procedures" : "Diagnostic procedures", $importCount) . "!");
          }

          if( $updateCount ) {
            $this->addFlash('success', "Updated $updateCount " . ngettext($type == "TherapeuticProcedure" ? "Therapeutic procedure" : "Diagnostic procedure",$type == "TherapeuticProcedure" ? "Therapeutic procedures" : "Diagnostic procedures", $updateCount) . "!");
          }
        }
      }
      else {
        try {
            $reader = new ExcelReader(new \SplFileObject($file->getRealPath()), 0, $sheet);

            foreach ($reader as $row) {
              $obj = $em->getRepository("AppBundle:$type")->findOneByName($row['Name']);

              if( !$obj && $row['Name'] ) {
                $importCount++;
                $em->persist( $class::createFromArray($row) );
              } elseif( $row['Name'] ) {
                $obj->updateFromArray($row);

                $updateCount++;
              }
            }

            if( $importCount ) {
              $this->addFlash('success', "Imported $importCount " . ngettext($type == "TherapeuticProcedure" ? "Therapeutic procedure" : "Diagnostic procedure",$type == "TherapeuticProcedure" ? "Therapeutic procedures" : "Diagnostic procedures", $importCount) . "!");
            }

            if( $updateCount ) {
              $this->addFlash('success', "Updated $updateCount " . ngettext($type == "TherapeuticProcedure" ? "Therapeutic procedure" : "Diagnostic procedure",$type == "TherapeuticProcedure" ? "Therapeutic procedures" : "Diagnostic procedures", $updateCount) . "!");
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
