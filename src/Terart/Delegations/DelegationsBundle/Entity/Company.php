<?php

namespace Terart\Delegations\DelegationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 */
class Company
{
    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var string
     */
    private $locality;

    /**
     * @var string
     */
    private $nip;

    /**
     * @var \Terart\Delegations\DelegationsBundle\Entity\Countries
     */
    private $country;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set street
     *
     * @param string $street
     * @return Company
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Company
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     * @return Company
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set locality
     *
     * @param string $locality
     * @return Company
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set nip
     *
     * @param string $nip
     * @return Company
     */
    public function setNip($nip)
    {
        $this->nip = $nip;

        return $this;
    }

    /**
     * Get nip
     *
     * @return string
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * Set country
     *
     * @param  \Terart\Delegations\DelegationsBundle\Entity\Countries $country
     * @return Company
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Terart\Delegations\DelegationsBundle\Entity\Countries
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Company
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

    /**
     * Get translation phrase
     *
     * @return string
     */
    public function getTranslationPhrase()
    {
        return 'translations.' . $this->getName();
    }
}
