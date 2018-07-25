<?php
/**
 * src/AppBundle/Controller/DayController.php
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

		$finished = $user->getCurrentProgress();

		$form = $this->createFormBuilder()
			->add('diagnosis', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
				'label' => $finished == 'finished' ? 'Diagnosis' : 'Tentative Diagnosis',
				'label_attr' => array(
					'class' => 'is-large asterisk',
				),
			))
			->add('finish', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'label' => $finished == 'finished' ? 'Finish' : 'Go to next day',
				'attr' => array(
					'class' => 'button',
				),
			))->getForm();

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$diagnosis = $form->getData()['diagnosis'];

			$session->set('diagnosis-' . $user->getCurrentDay()->getId(), $diagnosis);

			if( $finished == 'finished' ) {
				return $this->redirectToRoute('reset');
			}

			return $this->redirectToRoute('nextDay');
		}

		$weight = $r->getSession()->has('estimated_weight') ? $r->getSession()->get('estimated_weight') : null;

		return $this->render('Default/review.html.twig', array(
			'user' => $user,
			'form' => $form->createView(),
			'animal_weight' => $weight,
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
			$user->setCurrentProgress('finished');

			$this->getDoctrine()->getManager()->flush();
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
