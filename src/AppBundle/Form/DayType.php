<?php
// src/AppBundle/Form/DayType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Entity\CaseStudy;
use AppBundle\Entity\Day;

class DayType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('hotspotsinfo', CollectionType::class, array(
				'entry_type' => HotspotType::class,
				'entry_options' => array(
					'attr' => array(
						'animal' => array_key_exists('animal', $options['attr']) ? $options['attr']['animal'] : null,
						'class' => 'notification',
				)),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__hotspot__',
				'attr' => array(
					'class' => 'collection hotspots',
					'data-type' => 'hotspot'
				),
			))
			->add('add hotspot', ButtonType::class, array(
				'attr' => array(
					'class' => 'addButton is-success',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('tests', CollectionType::class, array(
				'entry_type' => DiagnosticResultsType::class,
				'entry_options' => array(
					'attr' => array(
						'class' => 'notification',
					)
				),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__diagnostic-result__',
				'attr' => array(
					'data-type' => 'diagnostic result'
				),
			))
			->add('add diagnostic results', ButtonType::class, array(
				'attr' => array(
					'class' => 'addButton is-success',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('medications', CollectionType::class, array(
				'entry_type' => TherapeuticResultsType::class,
				'entry_options' => array(
					'attr' => array(
						'class' => 'notification',
					)
				),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__therapeutic-result__',
				'attr' => array(
					'data-type' => 'therapeutic result'
				),
			))
			->add('add therapeutic results', ButtonType::class, array(
				'attr' => array(
					'class' => 'addButton is-success',
					'onclick' => 'addButtonClickListener(this)',)));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => Day::class,
		));
	}
}
