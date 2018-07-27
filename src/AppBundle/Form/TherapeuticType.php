<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TherapeuticType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('therapeuticProcedure', 'AppBundle\Form\AbstractProcedureType', array(
        'label' => false,
        'data_class' => 'AppBundle\Entity\TherapeuticProcedure',
      ))
      ->add('dosage', null, array(
        'label_attr' => array(
          'class' => 'is-large asterisk',
        ),
      ))
      ->add('dosageInterval', null, array(
        'label_attr' => array(
          'class' => 'is-large asterisk',
        ),
      ))
      ->add('concentration', null, array(
        'label_attr' => array(
          'class' => 'is-large asterisk',
        ),
      ))
      ->add('costPerUnit', null, array(
        'required' => false,
        'attr' => array(
          'pattern' => '[0-9]+(\.[0-9]{1,2})?',
        ),
        'label_attr' => array(
          'class' => 'is-large',
        ),
      ))
      ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
        'attr' => array(
          'class' => 'is-success',
          'style' => 'margin-top: 1rem;',
        ),
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\TherapeuticProcedure',
    ));
  }
}
