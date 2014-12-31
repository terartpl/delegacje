<?php

namespace Terart\Delegations\DelegationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SettlementKm
 */
class SettlementKm
{
    /**
     * @var \DateTime
     */
    private $dateOfDeparture;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var integer
     */
    private $drivenKm;

    /**
     * @var string
     */
    private $ratePerKm;

    /**
     * @var string
     */
    private $value;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set dateOfDeparture
     *
     * @param \DateTime $dateOfDeparture
     * @return SettlementKm
     */
    public function setDateOfDeparture($dateOfDeparture)
    {
        $this->dateOfDeparture = $dateOfDeparture;

        return $this;
    }

    /**
     * Get dateOfDeparture
     *
     * @return \DateTime
     */
    public function getDateOfDeparture()
    {
        return $this->dateOfDeparture;
    }

    /**
     * Set from
     *
     * @param string $from
     * @return SettlementKm
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to
     *
     * @param string $to
     * @return SettlementKm
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set drivenKm
     *
     * @param integer $drivenKm
     * @return SettlementKm
     */
    public function setDrivenKm($drivenKm)
    {
        $this->drivenKm = $drivenKm;

        return $this;
    }

    /**
     * Get drivenKm
     *
     * @return integer
     */
    public function getDrivenKm()
    {
        return $this->drivenKm;
    }

    /**
     * Set ratePerKm
     *
     * @param string $ratePerKm
     * @return SettlementKm
     */
    public function setRatePerKm($ratePerKm)
    {
        $this->ratePerKm = $ratePerKm;

        return $this;
    }

    /**
     * Get ratePerKm
     *
     * @return string
     */
    public function getRatePerKm()
    {
        return $this->ratePerKm;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return SettlementKm
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
}
