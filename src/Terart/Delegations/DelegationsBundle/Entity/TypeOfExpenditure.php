<?php

namespace Terart\Delegations\DelegationsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TypeOfExpenditure
 */
class TypeOfExpenditure
{
    /**
     * @var
     */
    private $shortcut;

    /**
     * @var
     */
    private $translations;

    /**
     * @var string
     */
    private $expenditure;

    /**
     * @var integer
     */
    private $id;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /**
     * @param $shortcut
     * @return $this
     */
    public function setShortcut($shortcut)
    {
        $this->shortcut = $shortcut;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     * @param $translations
     * @return $this
     */
    public function setTranslations($translations)
    {
        $this->translations = $translations;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function removeTranslation($key)
    {
        if ($this->translations->containsKey($key)) {
            return $this->translations->remove($key);
        }
        return null;
    }

    /**
     * @return $this
     */
    public function removeTranslations()
    {
        $this->translations->clear();
        return $this;
    }

    /**
     * @param $key
     * @return null
     */
    public function getTranslation($key)
    {
        if ($this->translations->containsKey($key)) {
            return $this->translations->get($key);
        }
        return null;
    }

    public static function getTranFieldName()
    {
        return 'expenditure';
    }

    /**
     * Set expenditure
     *
     * @param string $expenditure
     * @return TypeOfExpenditure
     */
    public function setExpenditure($expenditure)
    {
        $this->expenditure = $expenditure;

        return $this;
    }

    /**
     * Get expenditure
     *
     * @return string
     */
    public function getExpenditure()
    {
        return $this->expenditure;
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
