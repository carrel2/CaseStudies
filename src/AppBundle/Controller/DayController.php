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

/**
 * DayController class
 *
 * DayController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class DayController extends Controller
{
	/**
	 * reviewAction function
	 *
	 * Renders review.html.twig
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **review.html.twig**
	 *
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

		$form = $this->createFormBuilder()
			->add('diagnosis', TextareaType::class)
			->add('finish', SubmitType::class, array(
				'attr' => array(
					'class' => 'button',
				),
			))->getForm();

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$diagnosis = $form->getData()['diagnosis'];

			$session->set('diagnosis', $diagnosis);

			return $this->redirectToRoute('reset');
		}

		$finished = $session->get('finished');

		return $this->render('Default/review.html.twig', array(
			'user' => $user,
			'finished' => $finished,
			'form' => $form->createView(),
		));
	}

	/**
	 * logicAction function
	 *
	 * Function to handle the logic between Day objects
	 *
	 * @see Day::class
	 *
	 * @todo update logic to be more dynamic, extend past actual CaseStudy
	 * @todo add email functionality
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 * @Route("/logic", name="logic")
	 */
	public function logicAction(Request $r)
	{
		$user = $this->getUser();
		$case = $user->getCaseStudy();

		if( count($case->getDays()) == count($user->getDays())) {
			$r->getSession()->set('finished', true);
			$this->addFlash('complete', 'Finish message.');

			// $message = \Swift_Message::newInstance()
			// 	->setSubject('Test message')
			// 	->setFrom('send@example.com')
			// 	->setTo('vaulter82@gmail.com')
			// 	->setBody('Finished');
			//
			// $this->get('mailer')->send($message);

			// return $this->render('debug.html.twig', array(
			// 	'days' => $user->getDays(),
			// ));
		}

		return $this->redirectToRoute('review');
	}

	/**
	 * nextAction function
	 *
	 * Creates a new UserDay for the User and redirects to evaluation page
	 *
	 * @see UserDay::class
	 * @see User::class
	 * @see HotSpotController::showPageAction()
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Redirect to **HotSpotController::showPageAction()**
	 *
	 * @Route("/nextDay", name="nextDay")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function nextAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();

		$user->addDay(new UserDay());

		$em->flush();

		$r->getSession()->set('page', 'evaluation');

		return $this->redirectToRoute('evaluation');
	}
}
