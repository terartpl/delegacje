<?php

namespace Terart\Delegations\DelegationsBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Terart\Delegations\DelegationsBundle\Entity\DelegationKmGroup;
use Terart\Delegations\DelegationsBundle\Entity\DelegationOtherCosts;
use Terart\Delegations\DelegationsBundle\Form\Type\Datetimepicker;

class DelegationsType extends AbstractType
{

    public $delegationTypeClassName = 'Terart\Delegations\DelegationsBundle\Entity\DelegationType';
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $default_country = $options['default_country'];
        $locale = $options['locale'];
        $builder
            ->add('defaultCurrency', 'hidden', array('label' => false, 'attr' => array('class' => ''), 'data' => $options['default_currency'], 'mapped' => false))
            ->add('username', 'text', array('label' => 'translations.Username', 'attr' => array('class' => 'form-control'), 'disabled' => true, 'data' => $options['user']->getUsername(), 'mapped' => false))
            ->add('name', 'text', array('label' => 'translations.Name', 'attr' => array('class' => 'form-control'), 'disabled' => true, 'data' => $options['user']->getName(), 'mapped' => false))
            ->add('lastname', 'text', array('label' => 'translations.Surname', 'attr' => array('class' => 'form-control'), 'disabled' => true, 'data' => $options['user']->getSurname(), 'mapped' => false))
            ->add('company', 'text', array('label' => 'translations.Company', 'attr' => array('class' => 'form-control'), 'disabled' => true, 'data' => $options['user']->getCompany()->getName(), 'mapped' => false))
            ->add('nrDelegation', 'text', array('label' => 'translations.Nrdelegation', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => '')))
            ->add('placeACost', 'text', array('label' => 'translations.Placeacost', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => '')))
            ->add('targetCountryType', 'entity',
                array('class' => 'Terart\Delegations\DelegationsBundle\Entity\TargetCountryType',
                    'property' => 'name',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('TargetCountryType');
                    },
                    'required' => true,
                    'empty_value' => 'translations.ChooseOption',
                    'label' => 'translations.TargetCountryDelegations',
                    'attr' => array('class' => 'form-control'),
                    'translation_domain' => 'dict'
                )
            )
            ->add('targetCountry', 'entity',
                array('class' => 'Terart\Delegations\DelegationsBundle\Entity\Countries',
                    'property' => 'name',
                    'query_builder' => function (EntityRepository $er) use ($default_country) {
                        $query = $er->createQueryBuilder('Countries')->orderBy('Countries.name', 'ASC')->where('Countries.name != \'' . $default_country . '\'');
                        return $query;
                    },
                    'required' => false,
                    'empty_value' => 'translations.ChooseOption',
                    'label' => false,
                    'attr' => array('class' => 'form-control'),
                    'translation_domain' => 'countries'
                )
            )
            ->add('type', 'choice',
                array(
                    'choices' => $this->getDelegationTypeChoiceList($locale, $options['em']),
                    'placeholder' => 'translations.ChooseOption',
                    'required' => true,
                    'label' => 'translations.TypeDelegation',
                    'attr' => array('class' => 'form-control'),
                    'translation_domain' => 'dict'
                )
            )
            ->add('destination', 'text', array('label' => 'translations.Destination', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => '')))
            ->add('dateFrom', new Datetimepicker(), array('label' => 'translations.Datefrom', 'attr' => array('class' => 'form-control input-md control-date-start dpicker')))
            ->add('dateTo', new Datetimepicker(), array('label' => 'translations.Dateto', 'attr' => array('class' => 'form-control input-md control-date-start dpicker')))
            ->add('purposeOfTrip', 'text', array('label' => 'translations.Purposeoftrip', 'attr' => array('class' => 'form-control'), 'label_attr' => array('class' => '')))
            ->add('isPrivateCar',
                'checkbox',
                array(
                    'label' => 'translations.Isprivatecar',
                    'attr' => array('class' => 'ignore'),
                    'label_attr' => array('class' => ''),
                    'required' => false
                )
            )
            ->add('address', 'text', array('label' => 'translations.Address', 'attr' => array('class' => 'ignore form-control'), 'label_attr' => array('class' => ''), 'required' => false))
            ->add('carNumber', 'text', array('label' => 'translations.Carnumber', 'attr' => array('class' => 'form-control ignore'), 'label_attr' => array('class' => ''), 'required' => false))
            ->add('engineCapacity', 'choice', array('label' => 'translations.Enginecapacity', 'attr' => array('class' => 'ignore engineCapacity'), 'label_attr' => array('class' => ''), 'expanded' => true, 'choices' => array('0' => 'translations.lt', '1' => 'translations.gte'), 'required' => true));
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
            $em = $form->getConfig()->getOptions()['em'];
            $locale = $form->getConfig()->getOptions()['locale'];

            if ($delegationType = $data->getType()) {
                if($delegationType instanceof $this->delegationTypeClassName) {
                    $data->setType($delegationType->getId());
                }

            }

            $group = new DelegationKmGroup();
            if ($data->getId()) {
                $groupArray = $em->getRepository("DelegationsBundle:DelegationKmGroup")->findBy(array('delegation' => $data->getId()));
                $resultGr = array();
                foreach ($groupArray as $gr) {
                    array_push($resultGr, $gr->getSettlementKm());
                }
                $group->setSettlementKm($resultGr);
            }

            $data->setSettlementKm($group);

            $form->add(
                'settlementKm',
                'collection',
                array(
                    'property_path' => 'settlementKm.settlementKm',
                    'label' => 'translations.SettlementKm',
                    'type' => new SettlementKmType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'options' => array(
                        'required' => false,
                    )
                )
            );

            $group = new DelegationOtherCosts();
            if ($data->getId()) {
                $groupArray = $em->getRepository("DelegationsBundle:DelegationOtherCosts")->findBy(array('delegation' => $data->getId()));
                $trans = $em->getRepository("DelegationsBundle:DelegationOtherCosts")->findAllTranslations($data->getId(), $locale);
                $resultGr = array();
                foreach ($groupArray as $gr) {
                    $expenditure = $gr->getSettlementOfOtherCost()->getTypeOfExpenditure();
                    if (isset($trans[$expenditure->getId()])) {
                        $opt = array(
                            'id' => $expenditure->getId(),
                            'expenditure' => $trans[$expenditure->getId()],
                        );
                        $gr->getSettlementOfOtherCost()->setTypeOfExpenditure(json_encode($opt));
                        array_push($resultGr, $gr->getSettlementOfOtherCost());
                    }
                }
                if (!empty($resultGr)) {
                    $group->setSettlementOfOtherCost($resultGr);
                }
            }

            $data->setSettlementOther($group);
            $form->add(
                'settlementOther',
                'collection',
                array(
                    'property_path' => 'settlementOther.settlementOfOtherCost',
                    'label' => 'translations.SettlementOther',
                    'type' => new SettlementOfOtherCostsType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'options' => array(
                        'required' => false,
                        'em' => $em,
                        'locale' => $locale
                    )
                )
            );
            $event->setData($data);
            $form->add(
                'advance',
                'text',
                array(
                    'label' => 'translations.Advance',
                    'attr' => array('class' => 'form-control ignore text-right'),
                    'label_attr' => array('class' => ''),
                    'empty_data' => '0',
                )
            );

        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
            $em = $form->getConfig()->getOptions()['em'];
            if ($data->getType()) {
                $delegationType = $em->getRepository("DelegationsBundle:DelegationType")->find($data->getType());
                $data->setType($delegationType);
                $event->setData($data);
            }
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Terart\Delegations\DelegationsBundle\Entity\Delegations',
            'translation_domain' => 'DelegationsBundle',
            'user' => 'Terart\Delegations\DelegationsBundle\Entity\Users',
            'em' => 'Doctrine\ORM\EntityManager',
            'default_currency' => 'String',
            'default_country' => 'String',
            'locale' => 'String'
        ))->setRequired(array(
            'user',
            'default_currency',
            'default_country',
            'locale',
            'em'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'delegations';
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $em = $form->getConfig()->getOptions()['em'];
        $locale = $form->getConfig()->getOptions()['locale'];
        $data = $form->getData();

        if (is_object($data) && $data->getId()) {
            $group = new DelegationOtherCosts();
            $groupArray = $em->getRepository("DelegationsBundle:DelegationOtherCosts")->findBy(array('delegation' => $data->getId()));
            $trans = $em->getRepository("DelegationsBundle:DelegationOtherCosts")->findAllTranslations($data->getId(), $locale);
            $resultGr = array();
            foreach ($groupArray as $gr) {
                $expenditure = $gr->getSettlementOfOtherCost()->getTypeOfExpenditure();
                if (is_string($expenditure)) {
                    continue;
                }
                if (isset($trans[$expenditure->getId()])) {
                    $opt = array(
                        'id' => $expenditure->getId(),
                        'expenditure' => $trans[$expenditure->getId()],
                    );
                    $gr->getSettlementOfOtherCost()->setTypeOfExpenditure(json_encode($opt));
                    array_push($resultGr, $gr->getSettlementOfOtherCost());
                }
            }
            if (!empty($resultGr)) {
                $group->setSettlementOfOtherCost($resultGr);
                $form->getData()->setSettlementOther($group);
            }

        }
    }

    private function getDelegationTypeChoiceList($locale, $em) {
        return $em->getRepository('DelegationsBundle:DelegationType')->findAllTranslations('hashKey', $locale, 'choicelist');
    }
}