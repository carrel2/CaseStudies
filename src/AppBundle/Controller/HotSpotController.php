<?php
// src/AppBundle/Controller/HotSpotController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\HotSpots;

class HotSpotController extends Controller
{
	/**
	 * @Route("/eval", name="evaluation")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPage(Request $r, $id)
	{
		$user = $this->getUser();
		$id = $r->getSession()->get('session');

		$repo = $this->getDoctrine()->getRepository('AppBundle:Session');
		$session = $repo->find( $id );

		$repo = $this->getDoctrine()->getRepository('AppBundle:Day');
		$day = $repo->find( $session->getDay() );

		$repo = $this->getDoctrine()->getRepository('AppBundle:HotSpots');
		$hotspots = $repo->findByCaseId( $session->getCaseId() );
		$checked = array();

		foreach( $day->getHotspots() as $hotspot ) {
			array_push( $checked, $hotspot );
		}

		return $this->render('hotspot.html.twig', array(
			'session' => $session,
			'hotspots' => $hotspots,
			'checked' => $checked,
		));
	}

	/**
	 * @Route("/update/{session}/{id}", name="update")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function updatePage(Request $r, $session, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$hotspot = $em->getRepository('AppBundle:HotSpots')->find($id);

		$session = $em->getRepository('AppBundle:Session')->find($session);
		$day = $em->getRepository('AppBundle:Day')->find($session->getDay());

		if( !$hotspot ) {
			throw $this->createNotFoundException('No info found');
		}

		$day->addHotspot($hotspot);
		$em->flush();

		return $this->redirectToRoute('evaluation');
		//return new Response($hotspot->getName() . ": " . $hotspot->getInfo());
	}

	/**
	 * @Route("/reset", name="reset")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function resetPage()
	{
		$em = $this->getDoctrine()->getManager();
		$hotspots = $em->getRepository('AppBundle:HotSpots')->findAll();

		foreach( $hotspots as $spot ) {
			$spot->setChecked("false");
		}

		$em->flush();

		return $this->redirectToRoute('evaluation');
	}
}
