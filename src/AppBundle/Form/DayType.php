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
		$builder->add('description', 'Ivory\CKEditorBundle\Form\Type\CKEditorType', array(
				'label_attr' => array(
					'class' => 'is-large',
				),
				'config' => array(
					'autoParagraph' => false,
					'disallowedContent' => 'button embed form iframe input link meta textarea video script',
				),
			))
			->add('hotspotsinfo', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
				'entry_type' => 'AppBundle\Form\HotspotType',
				'entry_options' => array(
					'attr' => array(
						'animal' => array_key_exists('animal', $options['attr']) ? $options['attr']['animal'] : null,
						'class' => 'notification',
				)),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__hotspot__',
				'label' => 'Hotspots',
				'label_attr' => array(
					'class' => 'is-large',
				),
				'attr' => array(
					'class' => 'collection hotspots',
					'data-type' => 'hotspot'
				),
			))
			->add('add hotspot', 'Symfony\Component\Form\Extension\Core\Type\ButtonType', array(
				'attr' => array(
					'class' => 'addButton is-success',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('tests', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
				'entry_type' => 'AppBundle\Form\DiagnosticResultsType',
				'entry_options' => array(
					'attr' => array(
						'class' => 'notification',
					)
				),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__diagnostic-result__',
				'label' => 'Diagnostics',
				'label_attr' => array(
					'class' => 'is-large',
				),
				'attr' => array(
					'class' => 'collection tests',
					'data-type' => 'diagnostic result'
				),
			))
			->add('add diagnostic results', 'Symfony\Component\Form\Extension\Core\Type\ButtonType', array(
				'attr' => array(
					'class' => 'addButton is-success',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('medications', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
				'entry_type' => 'AppBundle\Form\TherapeuticResultsType',
				'entry_options' => array(
					'attr' => array(
						'class' => 'notification',
					)
				),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__therapeutic-result__',
				'label' => 'Therapeutics',
				'label_attr' => array(
					'class' => 'is-large',
				),
				'attr' => array(
					'class' => 'collection medications',
					'data-type' => 'therapeutic result'
				),
			))
			->add('add therapeutic results', 'Symfony\Component\Form\Extension\Core\Type\ButtonType', array(
				'attr' => array(
					'class' => 'addButton is-success',
					'onclick' => 'addButtonClickListener(this)',)));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Day',
		));
	}
}
