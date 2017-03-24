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
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__hotspot__',
				'attr' => array(
					'class' => 'collection hotspots',
					'data-type' => 'hotspot'),))
			->add('add hotspot', ButtonType::class, array(
				'attr' => array(
					'class' => 'addButton',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('tests', CollectionType::class, array(
				'entry_type' => TestResultsType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__test-results__',
				'attr' => array(
					'class' => 'collection tests',
					'data-type' => 'test results'),))
			->add('add test results', ButtonType::class, array(
				'attr' => array(
					'class' => 'addButton',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('medications', CollectionType::class, array(
				'entry_type' => MedicationResultsType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__medication-results__',
				'attr' => array(
					'class' => 'collection medications',
					'data-type' => 'medication results'),))
			->add('add medication results', ButtonType::class, array(
				'attr' => array(
					'class' => 'addButton',
					'onclick' => 'addButtonClickListener(this)',)));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => Day::class,));
	}
}
