<?php
// src/AppBundle\Form\DefaultType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;
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
				$form->add('resume', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
					'attr' => array(
						'style' => 'margin-top: 1rem;',
					),
				))
					->add('abandon', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
						'attr' => array(
							'class' => 'is-danger',
							'style' => 'margin-top: 1rem;',
							'onclick' => 'return confirmDelete();',
						)
					));
			} else {
				$form->add('title', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
						'class' => 'AppBundle:CaseStudy',
						'label' => 'Case Study',
						'query_builder' => function(EntityRepository $er) {
							return $er->createQueryBuilder('cs')
								->leftJoin('cs.days', 'd')
								->where('d.caseStudy is not null')
								->orderBy('cs.title', 'ASC');
						},
						'label_attr' => array(
							'class' => 'is-large',
						),
						'choice_label' => 'title',
						'attr' => array(
							'onchange' => 'updateCase()',
						),
					))
					->add('location', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
						'label' => 'Choose your location',
						'label_attr' => array(
							'class' => 'is-large asterisk',
						),
						'choices' => array(
							'Farm' => 'Farm',
							'Hospital' => 'Hospital',
						),
						'choices_as_values' => true,
						'expanded' => true,
					))
					->add('start', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
						'label' => "Begin Physical Examination",
						'attr' => array(
							'style' => 'margin-bottom: 1rem;',
						),
					));
			}
		});
	}
}
