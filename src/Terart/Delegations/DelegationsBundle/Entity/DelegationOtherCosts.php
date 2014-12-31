<?php

namespace Terart\Delegations\DelegationsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * DelegationOtherCosts
 */
class DelegationOtherCosts
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @ var /*\Terart\Delegations\DelegationsBundle\Entity\SettlementOfOtherCosts*
     */
    private $settlementOfOtherCost;

    /**
     * @var \Terart\Delegations\DelegationsBundle\Entity\Delegations
     */
    private $delegation;


    public function __construct()
    {
        $this->settlementOfOtherCost = new ArrayCollection();
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
     * Set settlementOfOtherCost
     *
     * @param array $settlementOfOtherCost
     * @return DelegationOtherCosts
     */
    public function setSettlementOfOtherCost($settlementOfOtherCost)
    {
        $this->settlementOfOtherCost = $settlementOfOtherCost;

        return $this;
    }

    /**
     * Get settlementOfOtherCost
     *
     * @return array
     */
    public function getSettlementOfOtherCost()
    {
        return $this->settlementOfOtherCost;
    }

    /**
     * Set delegation
     *
     * @param $delegation
     * @return DelegationOtherCosts
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
