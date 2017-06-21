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
		->add('title', TextType::class, array(
			'label_attr' => array(
				'class' => 'label case_title_label',
			)
		))
		->add('description', CKEditorType::class, array(
			'config' => array(
				'autoParagraph' => false,
				'disallowedContent' => 'button embed form iframe input link meta textarea video script',
			),
			'label_attr' => array(
				'class' => 'label case_description_label',
			)
		))
		->add('animal', EntityType::class, array(
			'class' => 'AppBundle:Animal',
			'choice_label' => 'name',
			'attr' => array(
				'onchange' => 'updateSelects("hotspot");',
			),
			'label_attr' => array(
				'class' => 'label case_animal_label',
			)
		))
		->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use($options) {
			$case = $event->getData();
			$form = $event->getForm();

			if( $case == null ) {
				$form->add('create', SubmitType::class, array(
					'attr' => array(
						'form' => 'case',
						'class' => 'is-success',
					),
				));
			} else {
				$form->add('days', CollectionType::class, array(
					'entry_type' => DayType::class,
					'entry_options' => array(
						'attr' => array_key_exists('data', $options) ? array('animal' => $options['data']->getAnimal()->getId()) : array(),
						'label_attr' => array(
							'class' => 'label day_label',
						)
					),
					'allow_add' => true,
					'allow_delete' => true,
					'by_reference' => false,
					'prototype_name' => '__day__',
					'attr' => array(
						'class' => 'select collection days',
						'data-type' => 'day'
					),
					'label_attr' => array(
						'class' => 'label case_days_label',
					)
					))
					->add('add day', ButtonType::class, array(
						'attr' => array(
							'class' => 'addButton is-success',
							'onclick' => 'addButtonClickListener(this)',
						)
					))
					->add('update', SubmitType::class, array(
						'attr' => array(
							'form' => 'case',
							'class' => 'is-success',
						),
					))
					->add('delete', SubmitType::class, array(
						'attr' => array(
							'form' => 'case',
							'class' => 'is-danger',
							'onclick' => 'return confirmDelete();',
						),
					))
					->add('restore', SubmitType::class, array(
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
				'data_class' => CaseStudy::class,
			));
		}
	}
