<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use AppBundle\Entity\HotSpotInfo;

class HotspotType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$animalId = $options['attr']['animal'];

		$builder->add('hotspot', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
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
			->add('info', 'FOS\CKEditorBundle\Form\Type\CKEditorType', array(
				'config' => array(
					'autoParagraph' => false,
				)
			));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\HotSpotInfo',
			'label' => false,
		));
	}
}
