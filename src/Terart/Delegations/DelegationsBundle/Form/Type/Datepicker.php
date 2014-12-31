<?php

namespace Terart\Delegations\DelegationsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

class Datepicker extends AbstractType
{
    public function getParent()
    {
        return 'date';
    }

    public function getName()
    {
        return 'input_datepicker';
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array('class' => 'dpicker'),
            'widget' => 'single_text'
        ));
    }
}
