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

class AdminController extends Controller
{
	/**
	 * @Route("/admin", name="admin")
	 */
	public function adminAction(Request $r)
	{
		$case = new CaseStudy();
		$form = $this->createForm( AdminType::class, $case );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$repo = $this->getDoctrine()->getRepository('AppBundle:CaseStudy');
		}

		return $this->render('admin.html.twig', array(
			'form' => $form->createView(),
			'case' => $case,
		));
	}

	/**
	 * @Route("/getCase/{id}")
	 */
	public function getCaseAction(Request $r, $id)
	{
		$repo = $this->getDoctrine()->getRepository('AppBundle:CaseStudy');
		$case = $repo->find($id);

		return $this->render('caseInfo.html.twig', array(
			'case' => $case,
		));
	}
}
