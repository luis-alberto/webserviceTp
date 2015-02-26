<?php

namespace LAP\WebserviceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;

class BootType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SUBMIT, function ($event) {
            $event->stopPropagation();
        }, 900);
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
            'data_class' => 'LAP\WebserviceBundle\Entity\Boot'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lap_webservicebundle_boot';
    }
}
