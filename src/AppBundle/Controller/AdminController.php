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
		$form = $this->createForm( AdminType::class );

		return $this->render('admin.html.twig', array(
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
			$em->flush();

			return $this->redirectToRoute('admin');
		}

		return $this->render('caseInfo.html.twig', array(
			'form' => $form->createView(),
			'id' => $id,
		));
	}
}
