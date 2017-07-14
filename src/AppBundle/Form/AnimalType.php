<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Animal;

class AnimalType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('image', FileType::class, array(
        'data' => '',
        'required' => false,
      ))
      ->add('name')
      ->add('submit', SubmitType::class, array(
        'attr' => array('class' => 'is-success'),
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => Animal::class,
    ));
  }
}
