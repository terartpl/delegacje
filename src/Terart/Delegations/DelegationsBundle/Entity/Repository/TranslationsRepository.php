<?php

namespace Terart\Delegations\DelegationsBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * TranslationsRepository
 *
 */
class TranslationsRepository extends EntityRepository
{
    public function findAllTranslations($field, $locale, $hydrator = 'translations')
    {
        if (!is_string($field) || !is_string($locale)) {
            return array();
        }
        $this->clear();
        if ($this->getClassMetadata()->hasField($field)) {
            $query = $this->getEntityManager()
                ->createQuery(
                    'SELECT e.id, e.' . $field . ', t.trans FROM ' . $this->getEntityName() . ' e
                        LEFT JOIN DelegationsBundle:Translations t
                        WHERE t.hashKey = e.' . $field . ' AND t.locale = \'' . $locale . '\' ORDER BY e.id DESC'
                );
            if ($hydrator) {
                return $query->getResult($hydrator);
            }
            return $query->getResult();
        }
        return array();
    }

    public function findTranslation($field, $locale, $id)
    {
        if (!is_string($id) || !is_string($field) || !is_string($locale)) {
            return null;
        }
        $this->clear();
        if ($this->getClassMetadata()->hasField($field)) {
            $query = $this->getEntityManager()
                ->createQuery(
                    'SELECT e.id, e.' . $field . ', t.trans FROM ' . $this->getEntityName() . ' e
                        LEFT JOIN DelegationsBundle:Translations t
                        WHERE t.hashKey = e.' . $field . ' AND t.locale = \'' . $locale . '\'
                        WHERE e.id = ' . $id
                );
            try {
                return $query->getSingleResult('translations');
            } catch (NoResultException $e) {
                return null;
            }

        }
        return null;
    }

    public function findTranslations($hashKey)
    {
        if (!is_string($hashKey)) {
            return array();
        }
        $this->clear();
        $query = $this->getEntityManager()->createQuery('SELECT t FROM DelegationsBundle:Translations t WHERE t.hashKey LIKE \'' . $hashKey . '\' ORDER BY t.id DESC');
        return $query->getResult();
    }

    public function getSelectList($locale)
    {
        $qb = $this->createQueryBuilder('e')
            ->select('t')
            ->join('DelegationsBundle:Translations', 't', 'WITH', 't.hashKey = e.expenditure')
            ->where('t.locale = :locale')
            ->setParameter('locale', $locale);
        return $qb;
    }

    public function findTranslationsByHashAndLocale($hashKey, $locale)
    {
        if (!is_string($hashKey) || !is_string($locale)) {
            return null;
        }
        $this->clear();
        $result = $this->getEntityManager()->createQuery('SELECT t FROM DelegationsBundle:Translations t WHERE t.hashKey LIKE \'' . $hashKey . '\' AND t.locale LIKE \'' . $locale . '\'')->getOneOrNullResult();
        if ($result) {
            return $result->getTrans();
        }
        return $result;
    }

}
