<?php

namespace Terart\Delegations\DelegationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SettlementOfOtherCosts
 */
class SettlementOfOtherCosts
{
    /**
     * @var string
     */
    private $originalAmount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var integer
     */
    private $isExchangeRate;

    /**
     * @var string
     */
    private $exchangeRate;

    /**
     * @var string
     */
    private $conversionAmount;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Terart\Delegations\DelegationsBundle\Entity\TypeOfExpenditure
     */
    private $typeOfExpenditure;


    /**
     * Set originalAmount
     *
     * @param string $originalAmount
     * @return SettlementOfOtherCosts
     */
    public function setOriginalAmount($originalAmount)
    {
        $this->originalAmount = $originalAmount;

        return $this;
    }

    /**
     * Get originalAmount
     *
     * @return string
     */
    public function getOriginalAmount()
    {
        return $this->originalAmount;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return SettlementOfOtherCosts
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set isExchangeRate
     *
     * @param integer $isExchangeRate
     * @return SettlementOfOtherCosts
     */
    public function setIsExchangeRate($isExchangeRate)
    {
        $this->isExchangeRate = $isExchangeRate;

        return $this;
    }

    /**
     * Get isExchangeRate
     *
     * @return integer
     */
    public function getIsExchangeRate()
    {
        return $this->isExchangeRate;
    }

    /**
     * Set exchangeRate
     *
     * @param string $exchangeRate
     * @return SettlementOfOtherCosts
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;

        return $this;
    }

    /**
     * Get exchangeRate
     *
     * @return string
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * Set conversionAmount
     *
     * @param string $conversionAmount
     * @return SettlementOfOtherCosts
     */
    public function setConversionAmount($conversionAmount)
    {
        $this->conversionAmount = $conversionAmount;

        return $this;
    }

    /**
     * Get conversionAmount
     *
     * @return string
     */
    public function getConversionAmount()
    {
        return $this->conversionAmount;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return SettlementOfOtherCosts
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set typeOfExpenditure
     *
     * @param $typeOfExpenditure
     * @return SettlementOfOtherCosts
     */
    public function setTypeOfExpenditure($typeOfExpenditure = null)
    {
        $this->typeOfExpenditure = $typeOfExpenditure;

        return $this;
    }

    /**
     * Get typeOfExpenditure
     *
     * @return \Terart\Delegations\DelegationsBundle\Entity\TypeOfExpenditure
     */
    public function getTypeOfExpenditure()
    {
        return $this->typeOfExpenditure;
    }
}
