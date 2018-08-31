<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TFox\MpdfPortBundle\Response\PDFResponse;
use Mpdf\Mpdf;
use AppBundle\Entity\Results;
use AppBundle\Entity\User;

class UserController extends Controller
{
	/**
	 * @Route("/user/results", name="results")
	 */
	public function resultsAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$results = $em->getRepository('AppBundle:Results')->findByUser($this->getUser());

		return $this->render('Default/results.html.twig', array(
			'results' => $results,
		));
	}

	/**
	 * @Route("/user/pdf/{results}", name="resultsToPdf")
	 */
	public function pdfAction(Request $r, Results $results)
	{
		$pdf = new Mpdf();

		$pdf->WriteHTML(file_get_contents('css/bulma.css'), 1);
		$pdf->WriteHTML($this->renderView('PDF/result.html.twig', array(
			'result' => $results,
		)), 2);

		return new PDFResponse($pdf->Output('tmp.pdf', \Mpdf\Output\Destination::STRING_RETURN));
	}
}
