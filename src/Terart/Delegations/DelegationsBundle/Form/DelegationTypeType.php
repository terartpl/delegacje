<?php

namespace Terart\Delegations\DelegationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Terart\Delegations\DelegationsBundle\Entity\Translations;

class DelegationTypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $diff = array_diff($options['locale_list'], array($options['locale']));
        $subBuilder = $builder->create('trans', 'form', array('by_reference' => false));
        $subBuilder->add($options['locale'], 'text', array('label' => array('label' => 'translations.DelegatiotypeName', 'locale' => '[' . mb_strtoupper($options['locale']) . ']'), 'attr' => array('class' => 'form-control'), 'constraints' => array(new NotBlank(), new Length(array('min' => 2, 'max' => 255)))));
        foreach ($diff as $d) {
            $subBuilder->add($d, 'text', array('label' => array('label' => 'translations.DelegatiotypeName', 'locale' => '[' . mb_strtoupper($d) . ']'), 'attr' => array('class' => 'form-control'), 'constraints' => array(new NotBlank(), new Length(array('min' => 2, 'max' => 255)))));
        }
        $builder->add($subBuilder);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            foreach ($data['trans'] as $transKey => $transVal) {
                $translation = new Translations();
                $translation->setLocale($transKey);
                $translation->setTrans($transVal);
                $data['trans'][$transKey] = $translation;
            }
            $event->setData($data);
        });


        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            if (!empty($data)) {
                $newData = array();
                foreach ($data as $d) {
                    $newData['trans'][$d->getLocale()] = $d->getTrans();
                }
                $event->setData($newData);
            }
        });

       /* $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();

            //$event->setData($newData);
        });*/

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'translation_domain' => 'DelegationsBundle',
            'locale' => 'String',
            'locale_list' => 'Array'
        ))->setRequired(
            array(
                'locale',
                'locale_list'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'delegationtype';
    }
}