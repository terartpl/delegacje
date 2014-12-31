<?php

namespace Terart\Delegations\DelegationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Translations
 */
class Translations
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $hashKey;

    /**
     * @var string
     */
    private $trans;


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
     * Set locale
     *
     * @param string $locale
     * @return Translations
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set hasKey
     *
     * @param string $hashKey
     * @return Translations
     */
    public function setHashKey($hashKey)
    {
        $this->hashKey = $hashKey;

        return $this;
    }

    /**
     * Get hashKey
     *
     * @return string
     */
    public function getHashKey()
    {
        return $this->hashKey;
    }

    /**
     * Set trans
     *
     * @param string $trans
     * @return Translations
     */
    public function setTrans($trans)
    {
        $this->trans = $trans;

        return $this;
    }

    /**
     * Get trans
     *
     * @return string
     */
    public function getTrans()
    {
        return $this->trans;
    }

    public function generateHash()
    {
        $hash = base_convert(uniqid(null, true), 10, 36);
        $this->setHashKey($hash);
        return $hash;
    }

}
