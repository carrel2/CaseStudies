<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Port\Excel\ExcelReader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Test;
use AppBundle\Entity\Medication;

class FileController extends Controller
{
  /**
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
      ->add('file', FileType::class)
      ->add('sheet', IntegerType::class, array(
        'required' => false,
        'scale' => 0,
        'empty_data' => null,
        'attr' => array('min' => 0),
      ))
      ->add('submit', SubmitType::class)
      ->getForm();

    $form->handleRequest($r);

    if( $form->isSubmitted() && $form->isValid() )
    {
      $type = $form->getData()['type'];
      $file = $form->getData()['file'];
      $sheet = abs($form->getData()['sheet']);
      $reader = new ExcelReader(new \SplFileObject($file->getRealPath()), 0, $sheet);

      if( $type == "Test" )
      {
        foreach ($reader as $row)
        {
          $row = array_change_key_case($row);
          if( !$em->getRepository('AppBundle:Test')->findOneByName($row["name"]) )
          {
            $em->persist(new Test($row));
          }
        }
      } else if( $type == "Medication" )
      {
        foreach ($reader as $row)
        {
          $row = array_change_key_case($row);
          if( !$em->getRepository('AppBundle:Medication')->findOneByName($row["name"]) )
          {
            $em->persist(new Medication($row));
          }
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
