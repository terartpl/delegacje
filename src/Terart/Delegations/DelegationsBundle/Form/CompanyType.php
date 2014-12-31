<?php

namespace Terart\Delegations\DelegationsBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $default_country = $options['default_country'];
        $builder
            ->add('name', 'text', array('label' => 'translations.Company', 'attr' => array('class' => 'form-control'), 'constraints' => array(new NotBlank(), new Length(array('min' => 2, 'max' => 255)))))
            ->add('street', 'text', array('label' => 'translations.Street', 'attr' => array('class' => 'form-control')))
            ->add('number', 'text', array('label' => 'translations.HouseNumber', 'attr' => array('class' => 'form-control')))
            ->add('zip_code', 'text', array('label' => 'translations.ZipCode', 'attr' => array('class' => 'form-control')))
            ->add('locality', 'text', array('label' => 'translations.Locality', 'attr' => array('class' => 'form-control')))
            ->add('country', 'entity',
                array('class' => 'Terart\Delegations\DelegationsBundle\Entity\Countries',
                    'property' => 'name',
                    'query_builder' => function (EntityRepository $er) use ($default_country) {
                        $query = $er->createQueryBuilder('Countries')->orderBy('Countries.name', 'ASC');
                        return $query;
                    },
                    'required' => false,
                    'empty_value' => 'translations.ChooseOption',
                    'label' => 'translations.Country',
                    'attr' => array('class' => 'form-control'),
                    'translation_domain' => 'countries'
                )
            )
            ->add('nip', 'text', array('label' => 'translations.Nip', 'attr' => array('class' => 'form-control')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terart\Delegations\DelegationsBundle\Entity\Company',
            'translation_domain' => 'DelegationsBundle',
            'default_country' => 'String'
        ))->setRequired(array(
            'default_country'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'company';
    }
}
