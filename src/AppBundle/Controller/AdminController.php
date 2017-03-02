<?php
/**
 * src/AppBundle/Controller/AdminController.php
 *
 * Controller for admin actions
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\CaseStudy;
use AppBundle\Form\AdminType;
use AppBundle\Form\CaseType;

/**
 * AdminController class
 *
 * AdminController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class AdminController extends Controller
{
	/**
	 * adminAction function
	 *
	 * Default admin action. Renders admin.html.twig template
	 *
	 * @todo fix security role
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **admin.html.twig**
	 *
	 * @Route("/admin", name="admin")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function adminAction(Request $r)
	{
		return $this->render('admin.html.twig');
	}

	/**
	 * editCaseAction function
	 *
	 * Creates a form for admins to use to edit CaseStudy objects
	 *
	 * @see CaseStudy::class
	 *
	 * @todo load edited case after submit
	 * @todo add undo functionality
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **editCase.html.twig**
	 *
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
	 * createCaseAction function
	 *
	 * Shows CaseType form for admins to create a new CaseStudy
	 *
	 * @see CaseType::class
	 * @see CaseStudy::class
	 * @see AdminController::adminAction()
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **createCase.html.twig**. On submission, redirect to **AdminController::adminAction()**
	 *
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
	 * getCaseAction function
	 *
	 * Function to get a case study and all information associated with it. Called through ajax.
	 * Returns caseInfo.html.twig template
	 *
	 * @param Request $r Request object
	 * @param CaseStudy $case CaseStudy object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **caseInfo.html.twig**. On submission, redirect to **AdminController::editCaseAction()**
	 *
	 * @Route("/getCase/{id}", name="caseInfo")
	 */
	public function getCaseAction(Request $r, CaseStudy $case)
	{
		$em = $this->getDoctrine()->getManager();

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
