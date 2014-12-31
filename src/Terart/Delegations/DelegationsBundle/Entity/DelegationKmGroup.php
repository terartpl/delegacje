<?php

namespace Terart\Delegations\DelegationsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * DelegationKmGroup
 */
class DelegationKmGroup
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var ArrayCollection// \Terart\Delegations\DelegationsBundle\Entity\SettlementKm
     */
    private $settlementKm;

    /**
     * @var \Terart\Delegations\DelegationsBundle\Entity\Delegations
     */
    private $delegation;


    public function __construct()
    {
        $this->settlementKm = new ArrayCollection();
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
     * Set settlementKm
     *
     * @param array $settlementKm
     * @return DelegationKmGroup
     */
    public function setSettlementKm($settlementKm = null)
    {
        $this->settlementKm = $settlementKm;

        return $this;
    }

    /**
     * Get settlementKm
     *
     * @return array
     */
    public function getSettlementKm()
    {
        return $this->settlementKm;
    }

    /**
     * Set delegation
     *
     * @param $delegation
     * @return DelegationKmGroup
     */
    public function setDelegation($delegation = null)
    {
        $this->delegation = $delegation;

        return $this;
    }

    /**
     * Get delegation
     *
     * @return \Terart\Delegations\DelegationsBundle\Entity\Delegations
     */
    public function getDelegation()
    {
        return $this->delegation;
    }
}
