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
				'entry_options' => array('attr' => array('animal' => array_key_exists('animal', $options['attr']) ? $options['attr']['animal'] : null)),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__hotspot__',
				'attr' => array(
					'class' => 'select collection hotspots',
					'data-type' => 'hotspot'
				),
				'label_attr' => array(
					'class' => 'label hotspots_info_label',
				)
			))
			->add('add hotspot', ButtonType::class, array(
				'attr' => array(
					'class' => 'button addButton is-success',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('tests', CollectionType::class, array(
				'entry_type' => DiagnosticResultsType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__diagnostic-result__',
				'entry_options' => array(
					'attr' => array(
						'class' => 'checkbox',
					),
				),
				'attr' => array(
					'class' => 'field collection tests',
					'data-type' => 'diagnostic result'
				),
				'label_attr' => array(
					'class' => 'label tests_label',
				)
			))
			->add('add diagnostic results', ButtonType::class, array(
				'attr' => array(
					'class' => 'button addButton is-success',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('medications', CollectionType::class, array(
				'entry_type' => TherapeuticResultsType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__therapeutic-result__',
				'entry_options' => array(
					'attr' => array(
						'class' => 'checkbox',
					),
				),
				'attr' => array(
					'class' => 'field collection medications',
					'data-type' => 'therapeutic result'
				),
				'label_attr' => array(
					'class' => 'label medications_label',
				)
			))
			->add('add therapeutic results', ButtonType::class, array(
				'attr' => array(
					'class' => 'button addButton is-success',
					'onclick' => 'addButtonClickListener(this)',)));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => Day::class,
		));
	}
}
