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
			'checked' => $user->getCurrentDay()->getHotspots(),
		));
	}

	/**
	 * @Route("/update/{id}", name="update")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function updatePage(Request $r, HotSpots $hotspot)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();

		$user->getCurrentDay()->addHotspot($hotspot);

		$em->flush();

		return new Response('<li>' . $hotspot->getName() . ': ' . $hotspot->getInfo() . '</li>');
	}

	/**
	 * @Route("/reset", name="reset")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function resetPage(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$case = $user->getCaseStudy();

		$case->removeUser($user);
		$user->removeDays();

		$em->flush();
		return $this->render('debug.html.twig', array(
			'user' => $user,
			'case' => $case,
		));
		//return $this->redirectToRoute('default');
	}
}
