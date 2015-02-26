<?php

namespace LAP\WebserviceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StuffType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('rarity')
            ->add('level')
            ->add('weight')
            ->add('updatedAt')
            ->add('perso')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LAP\WebserviceBundle\Entity\Stuff'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lap_webservicebundle_stuff';
    }
}
