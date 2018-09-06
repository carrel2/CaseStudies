<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class HotspotType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$animalId = $options['attr']['animal'];

		$builder->add('hotspot', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:HotSpot',
				'query_builder' => function(EntityRepository $er) use($animalId) {
					return $er->createQueryBuilder('h')->where('h.animal = :id')->setParameter('id', $animalId);
				},
				'choice_label' => 'name',
				'attr' => array(
					'class' => 'hotspot',
				),
				'label' => false,
			))
			->add('info', 'Ivory\CKEditorBundle\Form\Type\CKEditorType', array(
				'label_attr' => array(
					'id' => 'day_Z_info_Z_label',
					'class' => 'asterisk',
				),
				'config' => array(
					'autoParagraph' => false,
				)
			))
			->add('sound', 'Symfony\Component\Form\Extension\Core\Type\FileType', array(
				'data' => '',
				'required' => false,
				'attr' => array(
					'accept' => '.mp3,.wav',
				),
				'label_attr' => array(
					'id' => 'day_Z_sound_Z_label',
					'class' => 'is-medium',
				)
			));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\HotSpotInfo',
			'label' => false,
		));
	}
}
