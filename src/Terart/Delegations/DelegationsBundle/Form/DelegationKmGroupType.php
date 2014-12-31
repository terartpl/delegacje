<?php

namespace Terart\Delegations\DelegationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Terart\Delegations\DelegationsBundle\Entity\Delegations;

class DelegationKmGroupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('delegation', new Delegations());
        $builder->add(
            'settlementKm',
            'collection',
            array(
                'type' => new SettlementKmType(),
                'allow_add' => true,
                'allow_delete' => true,
                'mapped' => false,
                'options' => array(
                    'required' => false,
                )
            )
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terart\Delegations\DelegationsBundle\Entity\DelegationKmGroup'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'delegationkmgroup';
    }
}
