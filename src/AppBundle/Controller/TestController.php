<?php
// src/AppBundle/Controller/TestController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Test;

class TestController extends Controller
{
	/**
	 * @Route("/tests", name="order_tests")
	 */
	public function showPage(Request $r)
	{
		$referer = $r->headers->get('referer');

		if( $referer !== 'http://127.0.0.1:8000/eval' ) {
			throw $this->createNotFoundException();
		} 

		return $this->render('tests.html.twig', array(
			'referer' => $r->headers->get('referer'),
		));
//		return $this->render('tests.html.twig', array(
//			'form' => $form->createView(),
//		));
	}
}
