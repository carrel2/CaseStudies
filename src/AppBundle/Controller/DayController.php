<?php
/**
 * src/AppBundle/Controller/DayController.php
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\UserDay;

class DayController extends Controller
{
	/**
	 * @Route("/review", name="review")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function reviewAction(Request $r)
	{
		$session = $r->getSession();
		$user = $this->getUser();

		if( !$user->getIsActive() ) {
			return $this->redirectToRoute('default');
		}

		$finished = $session->get('finished');

		$form = $this->createFormBuilder()
			->add('diagnosis', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
				'label' => $finished ? 'Diagnosis' : 'Tentative Diagnosis',
			))
			->add('finish', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'label' => $finished ? 'Finish' : 'Submit',
				'attr' => array(
					'class' => 'button',
				),
			))->getForm();

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$diagnosis = $form->getData()['diagnosis'];

			$session->set('diagnosis-' . $user->getCurrentDay()->getId(), $diagnosis);

			if( $finished ) {
				return $this->redirectToRoute('reset');
			}

			return $this->redirectToRoute('nextDay');
		}

		return $this->render('Default/review.html.twig', array(
			'user' => $user,
			'finished' => $finished,
			'form' => $form->createView(),
		));
	}

	/**
	 * @Route("/logic", name="logic")
	 */
	public function logicAction(Request $r)
	{
		$user = $this->getUser();
		$case = $user->getCaseStudy();

		if( count($case->getDays()) == count($user->getDays())) {
			$r->getSession()->set('finished', true);
		}

		return $this->redirectToRoute('review');
	}

	/**
	 * @Route("/nextDay", name="nextDay")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function nextAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();

		$user->addDay(new UserDay());

		$user->setCurrentProgress('evaluation');

		$em->flush();

		return $this->redirectToRoute('evaluation');
	}
}
