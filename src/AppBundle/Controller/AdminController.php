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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use AppBundle\Form\AdminUserType;
use AppBundle\Form\UserType;
use AppBundle\Entity\CaseStudy;
use AppBundle\Form\AdminType;
use AppBundle\Form\CaseType;
use AppBundle\Entity\User;

/**
 * AdminController class
 *
 * AdminController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @todo create forms to add tests and medications
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
	 * @todo look into consolidating admin.html.twig and adminUser.html.twig into one template
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **admin.html.twig**
	 *
	 * @Route("/admin", name="admin")
	 * @Security("has_role('ROLE_ADMIN')")
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
	 * @todo add undo functionality
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **editCase.html.twig**
	 *
	 * @Route("/admin/edit", name="editCase")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function editCaseAction(Request $r)
	{
		$form = $this->createForm( AdminType::class );

		$form->handleRequest($r);

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
	 * @Security("has_role('ROLE_ADMIN')")
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

			$this->addFlash('notice', 'Created ' . $case->getTitle());

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
	 * @Security("has_role('ROLE_ADMIN')")
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

			$r->getSession()->set('case', $case->getId());

			$this->addFlash('notice', 'Updated ' . $case->getTitle());

			return $this->redirectToRoute('editCase');
		}

		return $this->render('caseInfo.html.twig', array(
			'form' => $form->createView(),
			'case' => $case,
			'id' => $case->getId(),
		));
	}

	/**
	 * manageUsersAction function
	 *
	 * Allows admin User to edit User objects
	 *
	 * @see User::class
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **adminUser.html.twig**
	 *
	 * @Route("/admin/users", name="manageUsers")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function manageUsersAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm( AdminUserType::class );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() ) {
			$user = $form->getData()['users'];

			if( $form->get('edit')->isClicked() ) {
				return $this->redirectToRoute('updateUser', array(
					'id' => $user->getId(),
				));
			} else if( $form->get('delete')->isClicked() ) {
				$em->remove($user);
				$this->addFlash('notice', 'User deleted: ' . $user->getUsername());
				$em->flush();

				return $this->redirectToRoute('manageUsers');
			}
		}

		return $this->render('adminUser.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	 * editUserAction function
	 *
	 * Edit selected User object
	 *
	 * @param Request $r Request object
	 * @param User $user
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **user.html.twig**
	 *
	 * @Route("/admin/users/update/{id}", name="updateUser")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function editUserAction(Request $r, User $user)
	{
		$form = $this->createForm( UserType::class, $user );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$user = $form->getData();

			$plainPassword = $user->getPlainPassword();

			if( strlen($plainPassword) > 6 )
			{
				$password = $this->get('security.password_encoder')
					->encodePassword($user, $plainPassword);
				$user->setPassword($password);
			}

			try {
				$em->flush();

				$this->addFlash('notice', 'Changes saved for ' . $user->getUsername() );
			} catch( \Doctrine\ORM\ORMException $e ) {
				$this->addFlash('error', 'Something went wrong, changes were not saved!');
			}

			return $this->redirectToRoute('manageUsers');
		}

		return $this->render('adminUser.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
