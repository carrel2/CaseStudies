<?php
// src/AppBundle\Form\DefaultType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
			$case = $event->getData();
			$form = $event->getForm();

			if( $case ) {
				$form->add('resume', SubmitType::class, array(
					'attr' => array(
						//'class' => 'button is-success',
					)
				))
					->add('abandon', SubmitType::class, array(
						'attr' => array(
							'class' => 'is-danger',
							'onclick' => 'return confirmDelete();',
						)
					));
			} else {
				$form->add('title', EntityType::class, array(
						'class' => 'AppBundle:CaseStudy',
						'choice_label' => 'title',
						'attr' => array(
							'onchange' => 'updateCase()',
						),
					))
					->add('location', ChoiceType::class, array(
						'choices' => array(
							'Farm' => 'Farm',
							'Hospital' => 'Hospital',
						),
						'expanded' => true,
						'label_attr' => array(
							'class' => 'tooltip',
							'title' => 'Location affects the workflow of the application',
						)
					))
					->add('start', SubmitType::class);
			}
		});
	}
}
