<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Entity\HotSpotInfo;

class HotspotType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('hotspot', EntityType::class, array(
				'class' => 'AppBundle:HotSpot',
				'choice_label' => 'name',
				'attr' => array(
					'data-test' => implode(',',$options['attr']),
				)))
			->add('info', TextareaType::class);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => HotSpotInfo::class,
			'label' => false,
		));
	}
}
