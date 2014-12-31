<?php

namespace Terart\Delegations\DelegationsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Delegations
 */
class Delegations
{
    /**
     * @var string
     */
    private $nrDelegation;

    /**
     * @var string
     */
    private $placeACost;

    /**
     * @var string
     */
    private $destination;

    /**
     * @var \DateTime
     */
    private $dateFrom;

    /**
     * @var \DateTime
     */
    private $dateTo;

    /**
     * @var string
     */
    private $purposeOfTrip;

    /**
     * @var boolean
     */
    private $isPrivateCar;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $carNumber;

    /**
     * @var float
     */
    private $engineCapacity;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var Users
     */
    private $user;

    /**
     * @var DelegationType
     */
    private $type;

    /**
     * @var TargetCountryType
     */
    private $targetCountryType;

    /**
     * @var Countries
     */
    private $targetCountry;

    /**
     * @var ArrayCollection
     */
    private $settlementKm;

    /**
     * @var ArrayCollection
     */
    private $settlementOther;

    /**
     * @var string
     */
    private $advance;

    public function __construct()
    {
    }

    /**
     * Set settlementOther
     *
     * @param $settlement
     * @return Delegations
     */
    public function setSettlementOther($settlement)
    {
        $this->settlementOther = $settlement;

        return $this;
    }

    /**
     * Add settlementOther
     *
     * @param $settlement
     * @return Delegations
     */
    public function addSettlementOther($settlement)
    {
        $this->settlementOther[] = $settlement;

        return $this;
    }

    /**
     * Get settlementOther
     *
     * @return ArrayCollection
     */
    public function getSettlementOther()
    {
        return $this->settlementOther;
    }


    /**
     * Add settlementKm
     *
     * @param object $settlementKm
     * @return Delegations
     */
    public function addSettlementKm($settlementKm)
    {
        $this->settlementKm[] = $settlementKm;

        return $this;
    }

    /**
     * Set settlementKm
     *
     * @param object $settlementKm
     * @return Delegations
     */
    public function setSettlementKm($settlementKm)
    {
        $this->settlementKm = $settlementKm;

        return $this;
    }

    /**
     * Get settlementKm
     *
     * @return ArrayCollection
     */
    public function getSettlementKm()
    {
        return $this->settlementKm;
    }

    /**
     * Set nrDelegation
     *
     * @param string $nrDelegation
     * @return Delegations
     */
    public function setNrDelegation($nrDelegation)
    {
        $this->nrDelegation = $nrDelegation;

        return $this;
    }

    /**
     * Get nrDelegation
     *
     * @return string
     */
    public function getNrDelegation()
    {
        return $this->nrDelegation;
    }

    /**
     * Set placeACost
     *
     * @param string $placeACost
     * @return Delegations
     */
    public function setPlaceACost($placeACost)
    {
        $this->placeACost = $placeACost;

        return $this;
    }

    /**
     * Get placeACost
     *
     * @return string
     */
    public function getPlaceACost()
    {
        return $this->placeACost;
    }

    /**
     * Set destination
     *
     * @param string $destination
     * @return Delegations
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return Delegations
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     * @return Delegations
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set purposeOfTrip
     *
     * @param string $purposeOfTrip
     * @return Delegations
     */
    public function setPurposeOfTrip($purposeOfTrip)
    {
        $this->purposeOfTrip = $purposeOfTrip;

        return $this;
    }

    /**
     * Get purposeOfTrip
     *
     * @return string
     */
    public function getPurposeOfTrip()
    {
        return $this->purposeOfTrip;
    }

    /**
     * Set isPrivateCar
     *
     * @param boolean $isPrivateCar
     * @return Delegations
     */
    public function setIsPrivateCar($isPrivateCar)
    {
        $this->isPrivateCar = $isPrivateCar;

        return $this;
    }

    /**
     * Get isPrivateCar
     *
     * @return boolean
     */
    public function getIsPrivateCar()
    {
        return $this->isPrivateCar;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Delegations
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set carNumber
     *
     * @param string $carNumber
     * @return Delegations
     */
    public function setCarNumber($carNumber)
    {
        $this->carNumber = $carNumber;

        return $this;
    }

    /**
     * Get carNumber
     *
     * @return string
     */
    public function getCarNumber()
    {
        return $this->carNumber;
    }

    /**
     * Set engineCapacity
     *
     * @param float $engineCapacity
     * @return Delegations
     */
    public function setEngineCapacity($engineCapacity)
    {
        $this->engineCapacity = $engineCapacity;

        return $this;
    }

    /**
     * Get engineCapacity
     *
     * @return float
     */
    public function getEngineCapacity()
    {
        return $this->engineCapacity;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Delegations
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Delegations
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
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
     * Set user
     *
     * @param Users $user
     * @return Delegations
     */
    public function setUser(Users $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Terart\Delegations\DelegationsBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type
     *
     * @param DelegationType $type
     * @return Delegations
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return DelegationType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set advance
     *
     * @param float $advance
     * @return Delegations
     */
    public function setAdvance($advance = null)
    {
        $this->advance = $advance;

        return $this;
    }

    /**
     * Get advance
     *
     * @return string
     */
    public function getAdvance()
    {
        return $this->advance;
    }

    /**
     * Set target country type
     *
     * @param \Terart\Delegations\DelegationsBundle\Entity\TargetCountryType $targetType
     * @return Delegations
     */
    public function setTargetCountryType(TargetCountryType $targetType)
    {
        $this->targetCountryType = $targetType;

        return $this;
    }

    /**
     * Get target country type
     *
     * @return \Terart\Delegations\DelegationsBundle\Entity\TargetCountryType
     */
    public function getTargetCountryType()
    {
        return $this->targetCountryType;
    }

    /**
     * Set target country
     *
     * @param integer $targetCountry
     * @return Delegations
     */
    public function setTargetCountry($targetCountry)
    {
        $this->targetCountry = $targetCountry;

        return $this;
    }

    /**
     * Get target country
     *
     * @return \Terart\Delegations\DelegationsBundle\Entity\Countries
     */
    public function getTargetCountry()
    {
        return $this->targetCountry;
    }
}
