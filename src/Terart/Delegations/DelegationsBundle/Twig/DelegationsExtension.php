<?php

namespace Terart\Delegations\DelegationsBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;

class DelegationsExtension extends \Twig_Extension
{

    protected $em;
    protected $sessions;

    public function __construct(EntityManager $em, AttributeBag $sessions)
    {
        $this->em = $em;
        $this->sessions = $sessions;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('translation', array($this, 'translation')),
        );
    }

    public function translation($str, $locale = null)
    {
        if (!$locale && $this->sessions->has('_locale')) {
            $locale = $this->sessions->get('_locale');
        }
        $trans = $this->em->getRepository('DelegationsBundle:Translations')->findTranslationsByHashAndLocale($str, $locale);
        if ($trans) {
            return $trans;
        }
        return $str;
    }

    public function getName()
    {
        return 'delegations_extension';
    }
}