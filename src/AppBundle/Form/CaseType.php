<?php
// src/AppBundle/Form/CaseType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
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
			->add('days', CollectionType::class, array(
				'entry_type' => DayType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype_name' => '__day__',
				'attr' => array(
					'class' => 'collection days',
					'data-type' => 'day')))
			->add('add day', ButtonType::class, array(
				'attr' => array(
					'class' => 'addButton',
					'onclick' => 'addButtonClickListener(this)',)))
			->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
				$case = $event->getData();
				$form = $event->getForm();

				if( $case == null ) {
					$form->add('create', SubmitType::class, array(
						'attr' => array( 'form' => 'case',)));
				} else {
					$form->add('update', SubmitType::class, array(
							'attr' => array( 'form' => 'case',)))
						->add('delete', SubmitType::class, array(
							'attr' => array( 'form' => 'case',)))
						->add('restore', ButtonType::class, array(
							'attr' => array('onclick' => 'updateAdminCase()')));
				}
			});
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => CaseStudy::class,));
	}
}
