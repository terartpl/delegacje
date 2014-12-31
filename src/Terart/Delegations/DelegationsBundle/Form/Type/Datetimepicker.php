<?php

namespace Terart\Delegations\DelegationsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Datetimepicker extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array('class' => 'dtpicker'),
            'widget' => 'single_text',
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ));
    }

    public function getParent()
    {
        return 'datetime';
    }

    public function getName()
    {
        return 'input_datetimepicker';
    }
}
