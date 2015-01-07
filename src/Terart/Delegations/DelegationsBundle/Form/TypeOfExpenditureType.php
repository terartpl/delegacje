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

class TypeOfExpenditureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $diff = array_diff($options['locale_list'], array($options['locale']));
        $subBuilder = $builder->create('translations', 'form', array('by_reference' => false));
        $subBuilder->add($options['locale'], 'text', array('label' => array('label' => 'translations.DelegatiotypeName', 'locale' => '[' . mb_strtoupper($options['locale']) . ']'), 'attr' => array('class' => 'form-control'), 'constraints' => array(new NotBlank(), new Length(array('min' => 2, 'max' => 255)))));
        foreach ($diff as $d) {
            $subBuilder->add($d, 'text', array('label' => array('label' => 'translations.DelegatiotypeName', 'locale' => '[' . mb_strtoupper($d) . ']'), 'attr' => array('class' => 'form-control'), 'constraints' => array(new NotBlank(), new Length(array('min' => 2, 'max' => 255)))));
        }
        $builder->add($subBuilder);
        $builder->add('shortcut', 'text', array('label' => array('label' => 'translations.Shortcut', 'locale' => ''), 'attr' => array('class' => 'form-control'), 'constraints' => array(new NotBlank(), new Length(array('min' => 4, 'max' => 4)))));


        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $translated = array();
            $data = $event->getData();
            if ($data->getId() && $expenditure = $data->getExpenditure()) {
                $form = $event->getForm();
                $em = $form->getConfig()->getOptions()['em'];
                $translations = $em->getRepository('DelegationsBundle:Translations')->findTranslations($expenditure);
                foreach ($translations as $trans) {
                    $trans->setTrans(
                        $data->getTranslations()[$trans->getLocale()]
                    );
                }
                $data->setTranslations($translations);
                $event->setData($data);
                return;
            }
            $addedTrans = clone $data->getTranslations();
            $data->removeTranslations();
            $translation = new Translations();
            $data->setExpenditure($translation->generateHash());
            foreach ($addedTrans as $transKey => $trans) {
                if ($transKey == 'shortcut') {
                    $data->setShortcut($trans);
                }
                $translation->setLocale($transKey);
                $translation->setTrans($trans);
                array_push($translated, $translation);
                $translation = new Translations();
                $translation->setHashKey($data->getExpenditure());
            }
            unset($translation);
            $data->setTranslations($translated);
            $event->setData($data);
        });


        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
            if ($data->getId() && $expenditure = $data->getExpenditure()) {
                $em = $form->getConfig()->getOptions()['em'];
                $newData = array();
                $translations = $em->getRepository('DelegationsBundle:Translations')->findTranslations($expenditure);
                foreach ($translations as $trans) {
                    $newData[$trans->getLocale()] = $trans->getTrans();
                }
                $data->setTranslations($newData);
            }
            $event->setData($data);
        });

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terart\Delegations\DelegationsBundle\Entity\TypeOfExpenditure',
            'em' => 'Doctrine\ORM\EntityManager',
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
        return 'typeofexpenditure';
    }
}