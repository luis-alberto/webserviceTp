<?php

namespace LAP\WebserviceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('level')
            ->add('class')
            ->add('race')
            ->add('sexe')
            ->add('updatedAt')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LAP\WebserviceBundle\Entity\Perso'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lap_webservicebundle_perso';
    }
}
