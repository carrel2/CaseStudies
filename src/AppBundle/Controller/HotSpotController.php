<?php
// src/AppBundle/Controller/HotSpotController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\HotSpots;

class HotSpotController extends Controller
{
	/**
	 * @Route("/eval", name="evaluation")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPage(Request $r)
	{
		$user = $this->getUser();

		$case = $user->getCaseStudy();
		$days = $case->getDays();
		$hotspots = $days[0]->getHotspots();

		return $this->render('hotspot.html.twig', array(
			'hotspots' => $hotspots,
			'checked' => $hotspots,
		));
	}

	/**
	 * @Route("/update/{id}", name="update")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function updatePage(Request $r, $session, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$hotspot = $em->getRepository('AppBundle:HotSpots')->find($id);

		$session = $em->getRepository('AppBundle:Session')->find($session);
		$day = $session->getCurrentDay();

		if( !$day->getHotspots()->contains($hotspot) ) {
			$day->addHotspot($hotspot);
			$hotspot->setDay($day);
			$em->flush();

			return new Response($hotspot->getName() . ": " . $hotspot->getInfo());
		}

		//return $this->redirectToRoute('evaluation');
		return new Response('');
	}

	/**
	 * @Route("/reset", name="reset")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function resetPage()
	{
		$em = $this->getDoctrine()->getManager();

		$user = $this->getUser();
		$session = $user->getSession();

		$user->setSession(null);

		$em->remove($session);

		$em->flush();

		return $this->redirectToRoute('default');
	}
}
