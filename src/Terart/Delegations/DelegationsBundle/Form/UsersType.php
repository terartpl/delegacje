<?php

namespace Terart\Delegations\DelegationsBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'translations.Name', 'attr' => array('class' => 'form-control'), 'constraints' => array(new NotBlank(), new Length(array('min' => 2, 'max' => 255)))))
            ->add('surname', 'text', array('label' => 'translations.Surname', 'attr' => array('class' => 'form-control'), 'constraints' => array(new NotBlank(), new Length(array('min' => 2, 'max' => 255)))))
            ->add('username', 'text', array('label' => 'translations.Username', 'attr' => array('class' => 'form-control'), 'constraints' => array(new NotBlank(), new Length(array('min' => 2, 'max' => 255)))))
            ->add('email', 'text', array('label' => 'translations.Email', 'attr' => array('class' => 'form-control'), 'constraints' => array(new NotBlank(), new Length(array('min' => 2, 'max' => 255)), new Email())));
        if ($options['method'] != 'PUT') {
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

        $builder->add('isAdmin', 'checkbox', array('label' => 'translations.Isadmin', 'attr' => array('class' => 'ignore'), 'label_attr' => array('class' => ''), 'required' => false,))
            ->add('company', 'entity',
                array('class' => 'Terart\Delegations\DelegationsBundle\Entity\Company',
                    'property' => 'name',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('Company')
                            ->orderBy('Company.name', 'ASC');
                    },
                    'required' => true,
                    'empty_value' => 'translations.ChooseOption',
                    'label' => 'translations.Company',
                    'attr' => array('class' => 'form-control'),
                    'constraints' => array(new NotBlank()),
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
