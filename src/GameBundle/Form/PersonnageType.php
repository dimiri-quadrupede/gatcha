<?php

namespace GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Form\UploadableFileType;

class PersonnageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $up = new UploadableFileType('picture') ;
        
        $builder->add('name')
                ->add('attaque')
                ->add('defense')
                ->add('vie')
                ->add('rarete')
                ->add('evolution')
                ->add('icon', UploadableFileType::class , array('required' => false, 'label' => false))

                ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GameBundle\Entity\Personnage'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gamebundle_personnage';
    }


}
