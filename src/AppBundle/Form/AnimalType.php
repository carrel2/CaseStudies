<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('image', 'Symfony\Component\Form\Extension\Core\Type\FileType', array(
        'data' => '',
        'required' => false,
        'label_attr' => array(
          'class' => 'is-large asterisk',
        ),
      ))
      ->add('name', null, array(
        'label_attr' => array(
          'class' => 'is-large asterisk',
        ),
      ))
      ->add('category', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
        'class' => 'AppBundle:Category',
        'choice_label' => 'name',
        'attr' => array(
          'data-id' => 'category',
        ),
      ))
      ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
        'attr' => array('class' => 'is-success'),
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Animal',
    ));
  }
}
