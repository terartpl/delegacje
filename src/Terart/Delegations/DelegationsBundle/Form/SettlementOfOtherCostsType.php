<?php

namespace Terart\Delegations\DelegationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class SettlementOfOtherCostsType extends AbstractType
{
    /**
     * @var
     */
    protected $em;

    /**
     * @var
     */
    protected $locale;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->em = $options['em'];
        $locale = $this->locale = $options['locale'];
        $builder
            ->add('originalAmount', 'text', array('label' => 'translations.Amount', 'attr' => array('class' => 'form-control originalAmount', 'required' => true)))
            ->add('currency', 'choice',
                array(
                    'label' => 'translations.Currency',
                    'attr' => array(
                        'class' => 'form-control currency_choice_list',
                        'required' => true,
                    ),
                    'empty_value' => 'translations.ChooseOption',
                    'choices' => $this->getCurrencyList(),
                    'constraints' => array(new NotBlank())
                )
            )
            ->add('isExchangeRate', 'checkbox', array('label' => 'translations.isExchangeRate', 'attr' => array('class' => 'isExchangeRate', 'required' => false)))
            ->add('exchangeRate', 'text', array('label' => 'translations.RateOfExchange', 'attr' => array('class' => 'form-control exchangeRate', 'required' => false, 'readonly' => true)))
            ->add('conversionAmount', 'text', array('label' => 'translations.conversionAmount', 'attr' => array('class' => 'form-control conversionAmount', 'required' => true, 'readonly' => false)))
            /*->add('typeOfExpenditure', 'entity',
                array('class' => 'Terart\Delegations\DelegationsBundle\Entity\TypeOfExpenditure',
                    //'property' => 'trans',
                    'property' => 'expenditure',
                    'query_builder' => function(EntityRepository $er) use ($locale) {
                        $qb = $er->createQueryBuilder('TypeOfExpenditure')
                            ->orderBy('TypeOfExpenditure.expenditure', 'ASC');
                        return $qb;
                        //return $er->getSelectList($locale);
                    },
                    'required' => true,
                    'empty_value' => 'translations.ChooseOption',
                    'label' => 'translations.typeOfExpenditure',
                    'attr' =>array('class' => 'typeOfExpenditure form-control'),
                    'translation_domain' => 'dict'
                )
            )*/
            ->add('typeOfExpenditure', 'choice',
                array(
                    'choices' => $this->getChoicesList(),
                    'placeholder' => 'translations.ChooseOption',
                    'required' => true,
                    'label' => 'translations.typeOfExpenditure',
                    'attr' => array('class' => 'typeOfExpenditure form-control'),
                    'translation_domain' => 'dict'
                )
            )
            ->add('description', 'text', array('label' => 'translations.Description', 'attr' => array('class' => 'form-control settlementOtherDescription', 'required' => false), 'label_attr' => array('class' => '')));

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
            $em = $form->getConfig()->getOptions()['em'];
            if ($data->getTypeOfExpenditure()) {
                $typeOfExpenditure = $em->getRepository("DelegationsBundle:TypeOfExpenditure")->find($data->getTypeOfExpenditure());
                $data->setTypeOfExpenditure($typeOfExpenditure);
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
            'data_class' => 'Terart\Delegations\DelegationsBundle\Entity\SettlementOfOtherCosts',
            'em' => 'Doctrine\ORM\EntityManager',
            'locale' => 'String',
        ))->setRequired(array(
            'em',
            'locale',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'settlementofothercosts';
    }

    private function getCurrencyList()
    {
        return array(
            'EUR' => 'EUR', 'PLN' => 'PLN', 'GBP' => 'GBP', 'USD' => 'USD',
            'ALL' => 'ALL', 'AFN' => 'AFN', 'ARS' => 'ARS', 'AWG' => 'AWG',
            'AUD' => 'AUD', 'AZN' => 'AZN', 'BSD' => 'BSD', 'BBD' => 'BBD',
            'BDT' => 'BDT', 'BYR' => 'BYR', 'BZD' => 'BZD', 'BMD' => 'BMD',
            'BOB' => 'BOB', 'BAM' => 'BAM', 'BWP' => 'BWP', 'BGN' => 'BGN',
            'BRL' => 'BRL', 'BND' => 'BND', 'KHR' => 'KHR', 'CAD' => 'CAD',
            'KYD' => 'KYD', 'CLP' => 'CLP', 'CNY' => 'CNY', 'COP' => 'COP',
            'CRC' => 'CRC', 'HRK' => 'HRK', 'CUP' => 'CUP', 'CZK' => 'CZK',
            'DKK' => 'DKK', 'DOP' => 'DOP', 'XCD' => 'XCD', 'EGP' => 'EGP',
            'SVC' => 'SVC', 'EEK' => 'EEK', 'FKP' => 'FKP', 'FJD' => 'FJD',
            'GHC' => 'GHC', 'GIP' => 'GIP', 'GTQ' => 'GTQ', 'GGP' => 'GGP',
            'GYD' => 'GYD', 'HNL' => 'HNL', 'HKD' => 'HKD', 'HUF' => 'HUF',
            'ISK' => 'ISK', 'INR' => 'INR', 'IDR' => 'IDR', 'IRR' => 'IRR',
            'IMP' => 'IMP', 'ILS' => 'ILS', 'JMD' => 'JMD', 'JPY' => 'JPY',
            'JEP' => 'JEP', 'KZT' => 'KZT', 'KPW' => 'KPW', 'KRW' => 'KRW',
            'KGS' => 'KGS', 'LAK' => 'LAK', 'LVL' => 'LVL', 'LBP' => 'LBP',
            'LRD' => 'LRD', 'LTL' => 'LTL', 'MKD' => 'MKD', 'MYR' => 'MYR',
            'MUR' => 'MUR', 'MXN' => 'MXN', 'MNT' => 'MNT', 'MZN' => 'MZN',
            'NAD' => 'NAD', 'NPR' => 'NPR', 'ANG' => 'ANG', 'NZD' => 'NZD',
            'NIO' => 'NIO', 'NGN' => 'NGN', 'NOK' => 'NOK', 'OMR' => 'OMR',
            'PKR' => 'PKR', 'PAB' => 'PAB', 'PYG' => 'PYG', 'PEN' => 'PEN',
            'PHP' => 'PHP', 'QAR' => 'QAR', 'RON' => 'RON', 'RUB' => 'RUB',
            'SHP' => 'SHP', 'SAR' => 'SAR', 'RSD' => 'RSD', 'SCR' => 'SCR',
            'SGD' => 'SGD', 'SBD' => 'SBD', 'SOS' => 'SOS', 'ZAR' => 'ZAR',
            'LKR' => 'LKR', 'SEK' => 'SEK', 'CHF' => 'CHF', 'SRD' => 'SRD',
            'SYP' => 'SYP', 'TWD' => 'TWD', 'THB' => 'THB', 'TTD' => 'TTD',
            'TRY' => 'TRY', 'TRL' => 'TRL', 'TVD' => 'TVD', 'UAH' => 'UAH',
            'UYU' => 'UYU', 'UZS' => 'UZS', 'VEF' => 'VEF', 'VND' => 'VND',
            'YER' => 'YER', 'ZWD' => 'ZWD'
        );
    }

    private function getChoicesList()
    {
        return $this->em->getRepository('DelegationsBundle:TypeOfExpenditure')->findAllTranslations('expenditure', $this->locale, 'choicelistCost');

    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['costsType'] = $this->getChoicesList();
    }
}