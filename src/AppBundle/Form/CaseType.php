<?php
// src/AppBundle/Form/CaseType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\CaseStudy;
use AppBundle\Entity\HotSpots;

class CaseType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title', TextType::class)
			->add('description', TextareaType::class)
			->add('hotspots', CollectionType::class, array(
				'entry_type' => HotspotType::class,));

/*		foreach( $options["data"]->getHotspots() as $hotspot ) {
			$builder->add('name', TextType::class, array(
					'data' => $hotspot->getName(),
					'data_class' => HotSpots::class, ))
				->add('info', TextareaType::class, array(
					'data' => $hotspot->getInfo(),
					'data_class' => HotSpots::class, ));
		}
*/
		$builder->add('update', SubmitType::class);
	}
}
