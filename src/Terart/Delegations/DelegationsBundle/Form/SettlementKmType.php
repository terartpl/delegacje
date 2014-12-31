<?php

namespace Terart\Delegations\DelegationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Terart\Delegations\DelegationsBundle\Form\Type\Datetimepicker;

class SettlementKmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateOfDeparture', new Datetimepicker(), array('label' => 'translations.Datefrom', 'attr' => array('class' => 'form-control input-md control-date-start dpicker', 'required' => true)))
            ->add('from', 'text', array('label' => 'translations.From', 'attr' => array('class' => 'form-control settlementKmFrom', 'max_length' => '255', 'required' => true), 'label_attr' => array('class' => '')))
            ->add('to', 'text', array('label' => 'translations.To', 'attr' => array('class' => 'form-control settlementKmTo', 'max_length' => '255', 'required' => true), 'label_attr' => array('class' => '')))
            ->add('drivenKm', 'number', array('label' => 'translations.DrivenKm', 'attr' => array('class' => 'form-control drivenKm calc', 'required' => true), 'label_attr' => array('class' => ''), 'precision' => 2))
            ->add('ratePerKm', 'number', array('label' => 'translations.RatePerKm', 'attr' => array('class' => 'form-control ratePerKm calc', 'required' => true, 'value' => '0.8721'), 'label_attr' => array('class' => ''), 'precision' => 4))
            ->add('value', 'text', array('label' => 'translations.Value', 'attr' => array('class' => 'form-control value', 'readonly' => true), 'label_attr' => array('class' => '')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terart\Delegations\DelegationsBundle\Entity\SettlementKm'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'settlementkm';
    }
}
