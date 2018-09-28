<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
			->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
				$info = $event->getData();
				$form = $event->getForm();

				$form->add('sound', 'Symfony\Component\Form\Extension\Core\Type\FileType', array(
					'data' => '',
					'required' => false,
					'empty_data' => $info ? $info->getSound() : "",
					'attr' => array(
						'accept' => '.mp3,.wav',
						'data-sound' => $info ? $info->getSound() : "",
					),
					'label_attr' => array(
						'id' => 'day_Z_sound_Z_label',
						'class' => 'is-medium',
					)
				));

				if( $info && $info->hasSound() ) {
					$form->add('deleteSound', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array(
						'required' => false,
						'mapped' => false,
					));
				}
			})
			->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
				$info = $event->getData();
				$form = $event->getForm();

				if( $form->has('deleteSound') && $form->get('deleteSound')->getData() === true ) {
					$info->setSound(null);

					$event->setData($info);
				}
			});
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\HotSpotInfo',
			'label' => false,
		));
	}
}
