<?php
// src/AppBundle/Controller/AdminController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\CaseStudy;
use AppBundle\Form\AdminType;
use AppBundle\Form\CaseType;

class AdminController extends Controller
{
	/**
	 * @Route("/admin", name="admin")
	 */
	public function adminAction(Request $r)
	{
		return $this->render('admin.html.twig');
	}

	/**
	 * @Route("/admin/edit", name="editCase")
	 */
	public function editCaseAction(Request $r)
	{
		$form = $this->createForm( AdminType::class );

		return $this->render('editCase.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	 * @Route("/admin/create", name="createCase")
	 */
	public function createCaseAction(Request $r)
	{
		$form = $this->createForm( CaseType::class );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$case = $form->getData();

			$em->persist($case);
			$em->flush();

			return $this->redirectToRoute('admin');
		}

		return $this->render('createCase.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	 * @Route("/getCase/{id}", name="caseInfo")
	 */
	public function getCaseAction(Request $r, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('AppBundle:CaseStudy');
		$case = $repo->find($id);

		$form = $this->createForm( CaseType::class, $case );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$case = $form->getData();

			if( $form->get('update')->isClicked() ) {
				$em->persist($case);
			} else if( $form->get('delete')->isClicked() ) {
				$em->remove($case);
			}

			$em->flush();

			return $this->redirectToRoute('editCase');
		}

		return $this->render('caseInfo.html.twig', array(
			'form' => $form->createView(),
			'case' => $case,
			'id' => $id,
		));
	}
}
