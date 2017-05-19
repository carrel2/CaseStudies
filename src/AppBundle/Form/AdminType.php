<?php
// src/AppBundle/Form/AdminType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\CaseStudy;

/**
 * AdminType form class
 *
 * AdminType form class extends AbstractType
 *
 * @see http://api.symfony.com/3.2/Symfony/Component/Form/AbstractType.html
 */
class AdminType extends AbstractType
{
	/**
	 * buildForm()
	 *
	 * Builds the form
	 *
	 * @param FormBuilderInterface $builder
	 *
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('case', EntityType::class, array(
				'class' => 'AppBundle:CaseStudy',
				'choice_label' => 'title',
				'label_attr' => array(
					'class' => 'case_label',
				)
			));
	}
}
