<?php

namespace GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use GameBundle\Form\PortailBoxType;

use GameBundle\Entity\PortailBox;
use GameBundle\Entity\Personnage;

class PortailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
            ->add('name')
            ->add("startedAt")    
                ->add("endedAt", DateType::class, array(
    'widget' => 'single_text',
    // prevents rendering it as type="date", to avoid HTML5 date pickers
    // this is actually the default format for single_text
    'format' => 'dd/MM/yyyy',
    'html5' => false,
    // adds a class that can be selected in JavaScript
    'attr' => ['class' => 'js-datepicker']
                    )
                        )
            ->add('personnages', EntityType::class , array(
                
                'class' => Personnage::class,
                // before 2.7 use 'property' instead of 'choice_label'
                //'choice_label' => 'personnage', // equals $costTypeConnections->getDepartmentConnexion()->getType();
                'label' => 'Personnage :',
                'expanded' => true, // will output a set of inputs instead of a select tag
                'multiple' => true, // will output checkboxes instead of radio buttons
                'required' => true, // unused as multiple is true
            ))
                
            ->add('portailboxes', CollectionType::class, array(

                'entry_type'   => PortailBoxType::class
    
            ))    
               
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GameBundle\Entity\Portail'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '_portail';
    }


}
