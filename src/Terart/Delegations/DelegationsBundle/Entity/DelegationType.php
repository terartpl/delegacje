<?php

namespace Terart\Delegations\DelegationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DelegationType
 */
class DelegationType
{

    /**
     * @var string
     */
    private $hashKey;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set hash key
     *
     * @param string $hash
     * @return DelegationType
     */
    public function setHashKey($hash)
    {
        $this->hashKey = $hash;

        return $this;
    }

    /**
     * Get has key
     *
     * @return string
     */
    public function getHashKey()
    {
        return $this->hashKey;
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