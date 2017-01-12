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
		$repo = $this->getDoctrine()->getRepository('AppBundle:HotSpots');
		$hotspots = $repo->findAll();

		return $this->render('hotspot.html.twig', array(
			'hotspots' => $hotspots,
		));
	}

	/**
	 * @Route("/{session}/update/{id}", name="update")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function updatePage($session, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$hotspot = $em->getRepository('AppBundle:HotSpots')->find($id);

		if( !$hotspot ) {
			throw $this->createNotFoundException('No info found');
		}

		$hotspot->setChecked("true");
		$em->flush();

		return $this->redirectToRoute('evaluation');
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
