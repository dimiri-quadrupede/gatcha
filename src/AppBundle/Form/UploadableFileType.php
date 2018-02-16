<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UploadableFileType extends AbstractType
{
    public function __construct($type = 'file' ) {
        $this->type = $type;
        
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->type == 'picture') {
            $args = array('label' => 'Image', 'required' => false);
        } else {
            $args = array('label' => 'Fichier', 'required' => false);
        }
        
        $builder
            ->add('file', FileType::class , $args)
            ->add('type', HiddenType::class, array('data' => $this->type))
            ->add('name', HiddenType::class, array('required' => false))
            ->add("id" ,  HiddenType::class , array() )
                /**->add('path')
                ->add('mimeType')
                ->add('size')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('createdBy')
                ->add('updatedBy')**/
                ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UploadableFile'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_uploadablefile';
    }


}
