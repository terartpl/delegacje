<?php

namespace Terart\Delegations\DelegationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersPasswdType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('password', 'repeated',
            array(
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 2, 'max' => 255))
                ),
                'first_options' => array('label' => 'translations.Password'),
                'second_options' => array('label' => 'translations.RepeatPassword'),
                'type' => 'password',
                'required' => true,
                'options' => array('attr' => array('class' => 'form-control')),
            )
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terart\Delegations\DelegationsBundle\Entity\Users',
            'translation_domain' => 'DelegationsBundle',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'users';
    }
}
