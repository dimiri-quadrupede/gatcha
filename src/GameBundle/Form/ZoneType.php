<?php

namespace GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use GameBundle\Form\EpreuveType;

class ZoneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nom')
                ->add('epreuves', CollectionType::class, array(
                        // each entry in the array will be an "email" field
                        'entry_type'   => EpreuveType::class,
                                'prototype' => true,
                                'allow_add' => true,
                        // these options are passed to each "email" type
                        /*'entry_options'  => array(
                            'attr'      => array('class' => 'email-box')
                        ),*/
                    ))
                ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GameBundle\Entity\Zone'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '_zone';
    }


}
