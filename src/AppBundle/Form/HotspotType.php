<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use AppBundle\Entity\HotSpotInfo;

class HotspotType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$animalId = $options['attr']['animal'];

		$builder->add('hotspot', EntityType::class, array(
				'class' => 'AppBundle:HotSpot',
				'query_builder' => function(EntityRepository $er) use($animalId) {
					return $er->createQueryBuilder('h')->where('h.animal = :id')->setParameter('id', $animalId);
				},
				'choice_label' => 'name',
				'attr' => array(
					'class' => 'hotspot',
				),
				'label' => false,
			))
			->add('info', CKEditorType::class);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => HotSpotInfo::class,
			'label' => false,
		));
	}
}
