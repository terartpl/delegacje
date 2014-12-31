<?php

namespace Terart\Delegations\DelegationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DelegationOtherCostsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('settlementOfOtherCost')
            ->add('delegation');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terart\Delegations\DelegationsBundle\Entity\DelegationOtherCosts'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'terart_delegations_delegationsbundle_delegationothercosts';
    }
}
