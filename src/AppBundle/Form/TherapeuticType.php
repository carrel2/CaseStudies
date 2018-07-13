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
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\TherapeuticProcedure',
    ));
  }
}
