<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\HotSpot;
use AppBundle\Entity\HotSpotInfo;
use AppBundle\Entity\Animal;

class HotSpotController extends Controller
{
	/**
	* @Route("/eval", name="evaluation")
	* @Security("has_role('ROLE_USER')")
	*/
	public function showPageAction(Request $r)
	{
		$user = $this->getUser();

		if( !$user->getIsActive() || $user->getCurrentProgress() != 'evaluation' ) {
			return $this->redirectToRoute('default');
		}

		$case = $user->getCaseStudy();
		$animal = $case->getAnimal();
		$day = $case->getDays()[count($user->getDays()) - 1];
		$hotspots = $day->getHotspotsInfo();

		return $this->render('Default/hotspot.html.twig', array(
			'animal' => $animal,
			'size' => getimagesize("./images/{$animal->getImage()}"),
			'checked' => $user->getCurrentDay()->getHotspotsInfo(),
			'userDay' => $user->getCurrentDay(),
			'day' => $day,
		));
	}

	/**
	* @Route("/update/{id}", name="update", condition="request.isXMLHttpRequest()")
	* @Security("has_role('ROLE_USER')")
	*/
	public function updatePageAction(Request $r, HotSpot $hotspot)
	{
		$em = $this->getDoctrine()->getManager();
		$session = $r->getSession();
		$user = $this->getUser();
		$hotspots = $user->getCaseStudy()->getDays()[count($user->getDays()) - 1]->getHotspotsInfo();

		foreach ($hotspots as $info) {
			if( $info->getHotspot()->getId() == $hotspot->getId() && !$user->getCurrentDay()->getHotspotsInfo()->contains($info) )
			{
				$user->getCurrentDay()->addHotspotInfo($info);

				$em->flush();

				$audio = "";

				if( $info->hasSound() ) {
					$audio = "<span class='icon has-text-success' onclick='this.firstChild.play();'><audio src='{$this->get('templating.helper.assets')->getUrl('sounds/' . $info->getSound())}'></audio><i class='far fa-play-circle'></i></span>";
				}

				return new Response('<li>' . $audio . '<em>' . $hotspot->getName() . ':</em><span class="info"> ' . $info->getInfo() . '</span></li>');
			} else if( $info->getHotspot()->getId() == $hotspot->getId() && $user->getCurrentDay()->getHotspotsInfo()->contains($info) ) {
				return new Response('');
			}
		}

		if( false === array_search($hotspot->getName(), $session->getFlashBag()->peek('hotspot-' . $user->getCurrentDay()->getId())) )
		{
			$this->addFlash('hotspot-' . $user->getCurrentDay()->getId(), array('id' => $hotspot->getId(), 'name' => $hotspot->getName()));

			return new Response('<li><em>' . $hotspot->getName() . ':</em> No information available.</li>');
		}

		return new Response('');
	}

	/**
	* @Route("/addHotspot/{animal}/{name}", name="addHotspot")
	*/
	public function addHotspotAction(Request $r, Animal $animal, $name)
	{
		$coords = $r->request->get('coords');
		$hotspots = $animal->getHotspots();
		$spot = null;
		$name = ucfirst(strtolower(str_replace("%20", " ", $name)));

		foreach( $hotspots as $hotspot) {
			if( $hotspot->getName() === $name )
			{
				$spot = $hotspot;
			}
		}

		if( !$spot )
		{
			$spot = new HotSpot();
		}

		$spot->setName($name)->setCoords($coords);

		$animal->addHotspot($spot);

		$this->getDoctrine()->getManager()->flush();

		return $this->render('Ajax/hotspots.html.twig', array(
			'animal' => $animal,
		));
	}

	/**
	* @Route("/removeHotspot/{animal}/{hotspot}", name="removeHotspot")
	*/
	public function removeHotspotAction(Animal $animal, HotSpot $hotspot)
	{
		$animal->removeHotspot($hotspot);

		$this->getDoctrine()->getManager()->flush();

		return $this->redirectToRoute('editAnimal', array('id' => $animal->getId()));
	}

	/**
	 * QUESTION: is this being used?
	 *
	* @Route("/getAnimalInfo/{animal}/{type}", name="getAnimalInfo")
	*/
	public function getAnimalInfo(Animal $animal, $type = null)
	{
		$response = "";

		$type = "get" . str_replace(" ", "", ucwords($type)) . "s";

		foreach($animal->$type() as $info) {
			$response .= "<option value=\"{$info->getId()}\">{$info->getName()}</option>";
		}

		return new Response($response);
	}

	/**
	 * @Route("/eval/differentials/{moveOn}", name="differentials")
	 */
	public function differentialsAction(Request $r, $moveOn = false)
	{
		$session = $r->getSession();
		$diff = $r->request->get('explanation');
		$eWeight = $r->request->has('estimated_weight') ? $r->request->get('estimated_weight') : null;

		if( $eWeight ) {
			$session->set('estimated_weight', $eWeight);
		}

		if( $diff && $moveOn ) {
			$session->set("differentials-{$this->getUser()->getCurrentDay()->getId()}", $diff);
		} else if( !$moveOn ) {
			$session->set('modalUp', true);

			return $this->render('Ajax/differentials.html.twig');
		}

		$session->remove('modalUp');

		return new Response();
	}
}
