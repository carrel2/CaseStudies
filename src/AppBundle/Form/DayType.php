<?php
// src/AppBundle/Form/DayType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DayType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('number', TextType::class)
			->add('hotspots', CollectionType::class, array(
				'entry_type' => HotspotType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__hotspot__',
				'attr' => array('class' => 'hotspots'),))
			->add('tests', CollectionType::class, array(
				'entry_type' => TestResultsType::class,));
	}
}
