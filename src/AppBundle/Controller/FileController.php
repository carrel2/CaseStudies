<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Port\Excel\ExcelReader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Test;
use AppBundle\Entity\Medication;

/**
 * FileController class
 *
 * FileController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class FileController extends Controller
{
  /**
   * fileAction function
   *
   * @todo add tooltips
   *
   * @param Request $r Request object
   *
   * @return \Symfony\Component\HttpFoundation\Response Render **import.html.twig**
   *
   * @Route("/import", name="import")
   */
  public function fileAction(Request $r)
  {
    $reader = null;
    $em = $this->getDoctrine()->getManager();

    $form = $this->createFormBuilder()
      ->add('type', ChoiceType::class, array(
        'choices' => array('Medication' => 'Medication', 'Test' => 'Test'),
      ))
      ->add('file', FileType::class, array(
        'attr' => array(
          'accept' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ),
      ))
      ->add('sheet', TextType::class, array(
        'required' => false,
        'empty_data' => -1,
        'attr' => array(
          'pattern' => '^[1-9][0-9]*',
          'title' => 'The specific sheet to import data from',
        ),
      ))
      ->add('submit', SubmitType::class)
      ->getForm();

    $form->handleRequest($r);

    if( $form->isSubmitted() && $form->isValid() )
    {
      $count = 0;
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

              if( $row['name'] !== null && !$em->getRepository("AppBundle:$type")->findOneByName($row['name']) ) {
                $count++;
                $em->persist( new $class($row) );
              }
            }
          }
        } catch( \PHPExcel_Exception $e ) {
          $this->addFlash('notice', "Imported $count ${type}s!");
        }
      }
      else {
        try {
            $reader = new ExcelReader(new \SplFileObject($file->getRealPath()), 0, $sheet);

            foreach ($reader as $row) {
              $row = array_change_key_case($row);

              if( $row['name'] !== null && !$em->getRepository("AppBundle:$type")->findOneByName($row['name']) ) {
                $count++;
                $em->persist( new $class($row) );
              }
            }

            $this->addFlash('notice', "Imported $count ${type}s!");
          } catch( \PHPExcel_Exception $e ) {
            $this->addFlash('error', 'Invalid sheet number');
          }
      }

      $em->flush();
    }

    return $this->render('Default/import.html.twig', array(
      'form' => $form->createView(),
      'reader' => $reader,
    ));
  }
}
