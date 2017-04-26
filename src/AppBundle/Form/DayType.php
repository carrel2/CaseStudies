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
					'class' => 'button addButton',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('tests', CollectionType::class, array(
				'entry_type' => DiagnosticResultsType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__diagnostic-results__',
				'attr' => array(
					'class' => 'collection tests',
					'data-type' => 'diagnostic results'),))
			->add('add diagnostic results', ButtonType::class, array(
				'attr' => array(
					'class' => 'button addButton',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('medications', CollectionType::class, array(
				'entry_type' => TherapeuticResultsType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__therapeutic-results__',
				'attr' => array(
					'class' => 'collection medications',
					'data-type' => 'therapeutic results'),))
			->add('add therapeutic results', ButtonType::class, array(
				'attr' => array(
					'class' => 'button addButton',
					'onclick' => 'addButtonClickListener(this)',)));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => Day::class,
			'label' => false));
	}
}
