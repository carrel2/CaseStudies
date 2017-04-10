<?php
/**
 * src/AppBundle/Controller/HotSpotController.php
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\HotSpot;
use AppBundle\Entity\HotSpotInfo;
use AppBundle\Entity\Animal;

/**
 * HotSpotController class
 *
 * HotSpotController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class HotSpotController extends Controller
{
	/**
	 * showPageAction function
	 *
	 * Evaluation page. Retrieves all HotSpots from the current Day of the associated CaseStudy.
	 *
	 * @todo research 3d model functionality for HotSpots
	 *
	 * @see HotSpot::class
	 * @see Day::class
	 * @see CaseStudy::class
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **hotspot.html.twig**
	 *
	 * @Route("/eval", name="evaluation")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPageAction(Request $r)
	{
		$user = $this->getUser();
		$session = $r->getSession();

		if( !$user->getIsActive() || $session->get('page') != 'evaluation' ) {
			return $this->redirectToRoute('default');
		}

		$case = $user->getCaseStudy();
		$animal = $case->getAnimal();
		$days = $case->getDays();
		$hotspots = $days[count($user->getDays()) - 1]->getHotspotsInfo();

		return $this->render('Default/hotspot.html.twig', array(
			'animal' => $animal,
			'checked' => $user->getCurrentDay()->getHotspotsInfo(),
			'day' => $user->getCurrentDay(),
		));
	}

	/**
	 * updatePageAction function
	 *
	 * Called by ajax. Function to update UserDay with the HotSpots given
	 *
	 * @see HotSpots::class
	 * @see UserDay::class
	 *
	 * @param Request $r Request object
	 * @param HotSpots $hotspot The HotSpots to add to the current UserDay
	 *
	 * @return \Symfony\Component\HttpFoundation\Response If $hotspot was added to the **UserDay**, returns name and info. Returns empty string otherwise
	 *
	 * @Route("/update/{id}", name="update")
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

				return new Response('<li>' . $hotspot->getName() . ': ' . $info->getInfo() . '</li>');
			} else if( $info->getHotspot()->getId() == $hotspot->getId() && $user->getCurrentDay()->getHotspotsInfo()->contains($info) ) {
				return new Response('');
			}
		}

		if( !array_search($hotspot->getName(), $session->getFlashBag()->peek('hotspot-' . $user->getCurrentDay()->getId())) )
		{
			$this->addFlash('hotspot-' . $user->getCurrentDay()->getId(), $hotspot->getName());

			return new Response('<li>' . $hotspot->getName() . ': No information available.</li>');
		}

		return new Response('');
	}

	/**
	 * @Route("/addHotspot/{animal}/{name}/{x1}.{y1}.{x2}.{y2}", name="addHotspot")
	 */
	 public function addHotspotAction(Animal $animal, $name, $x1, $y1, $x2, $y2)
	 {
		 $hotspots = $animal->getHotspots();
		 $spot = null;
		 $name = ucfirst(strtolower($name));

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

		 $spot->setName($name)->setX1($x1)->setX2($x2)->setY1($y1)->setY2($y2);

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
}
