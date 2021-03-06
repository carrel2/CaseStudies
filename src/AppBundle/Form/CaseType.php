<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\CaseStudy;

class CaseType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('title', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
			'label_attr' => array(
				'id' => 'case_title_label',
				'class' => 'is-large asterisk',
			),
		))
		->add('description', 'Ivory\CKEditorBundle\Form\Type\CKEditorType', array(
			'label_attr' => array(
				'id' => 'case_description_label',
				'class' => 'is-large asterisk',
			),
			'config' => array(
				'autoParagraph' => false,
				'disallowedContent' => 'button embed form iframe input link meta textarea video script',
			),
		))
		->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
			'label_attr' => array(
				'id' => 'case_email_label',
				'class' => 'is-large asterisk',
			),
		))
		->add('animal', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
			'class' => 'AppBundle:Animal',
			'label_attr' => array(
				'id' => 'case_animal_label',
				'class' => 'is-large',
			),
			'choice_label' => 'name',
			'attr' => array(
				'onchange' => 'updateSelects("hotspot");',
			),
		))
		->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
			$case = $event->getData();
			$form = $event->getForm();

			if( $case == null ) {
				$form->add('create', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
					'attr' => array(
						'form' => 'case',
						'class' => 'is-success',
					),
				));
			} else {
				$form->add('days', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
					'entry_type' => 'AppBundle\Form\DayType',
					'entry_options' => array(
						'attr' => array(
							'class' => 'notification',
							'animal' => $case->getAnimal()->getId(),
						),
						'label_attr' => array(
							'id' => 'day_Z_label',
							'class' => 'is-large',
						),
					),
					'allow_add' => true,
					'allow_delete' => true,
					'by_reference' => false,
					'prototype_name' => '__day__',
					'attr' => array(
						'class' => 'collection days',
						'data-type' => 'day'
					),
					'label_attr' => array(
						'class' => 'label case_days_label is-large',
					)
					))
					->add('add day', 'Symfony\Component\Form\Extension\Core\Type\ButtonType', array(
						'attr' => array(
							'class' => 'addButton is-success',
							'onclick' => 'addButtonClickListener(this)',
						)
					))
					->add('update', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
						'attr' => array(
							'form' => 'case',
							'class' => 'is-success',
							'onclick' => 'return checkForCKEDITORNotEmpty();',
						),
					))
					->add('delete', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
						'attr' => array(
							'form' => 'case',
							'class' => 'is-danger',
							'onclick' => 'return confirmDelete();',
						),
					))
					->add('restore', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
						'attr' => array(
							'class' => 'is-info',
							'onclick' => 'updateAdminCase(); return false;',
						),
					));
				}
			});
		}

		public function configureOptions(OptionsResolver $resolver)
		{
			$resolver->setDefaults(array(
				'data_class' => 'AppBundle\Entity\CaseStudy',
			));
		}
	}
