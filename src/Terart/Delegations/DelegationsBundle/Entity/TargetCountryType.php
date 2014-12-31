<?php

namespace Terart\Delegations\DelegationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TargetCountryType
 */
class TargetCountryType
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     * @return TargetCountryType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
