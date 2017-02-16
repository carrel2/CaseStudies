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
		$builder->add('number', HiddenType::class, array(
				'attr' => array('class' => 'dayNumber')))
			->add('hotspots', CollectionType::class, array(
				'entry_type' => HotspotType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'attr' => array('class' => 'collection'),))
			->add('add hotspot', ButtonType::class, array(
				'attr' => array(
					'class' => 'addButton',
					'onclick' => 'addButtonClickListener(this)',)))
			->add('tests', CollectionType::class, array(
				'entry_type' => TestResultsType::class,))
			->add('add test results', ButtonType::class);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => Day::class,));
	}
}
