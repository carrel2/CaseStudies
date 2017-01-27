<?php
// src/AppBundle/Controller/TestsController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Test;
use AppBundle\Form\TestsType;

class TestsController extends Controller
{
	/**
	 * @Route("/tests", name="order_tests")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPage(Request $r)
	{
		$form = $this->createForm( TestsType::class );

		return $this->render('tests.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
