<?php

namespace Terart\Delegations\DelegationsBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class DelegationOtherCostsRepository
 * @package Terart\Delegations\DelegationsBundle\Entity\Repository
 */
class DelegationOtherCostsRepository extends EntityRepository
{

    /**
     * @param $delegationId
     * @param $locale
     * @return array
     */
    public function findAllTranslations($delegationId, $locale)
    {
        if (!$delegationId || !is_string($locale)) {
            return array();
        }
        $this->clear();
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT te.id, te.expenditure, t.trans as expenditure FROM DelegationsBundle:DelegationOtherCosts e
              LEFT JOIN DelegationsBundle:SettlementOfOtherCosts s WHERE s.id = e.settlementOfOtherCost
              LEFT JOIN DelegationsBundle:TypeOfExpenditure te WHERE te.id = s.typeOfExpenditure
              LEFT JOIN DelegationsBundle:Translations t WHERE t.hashKey = te.expenditure AND t.locale = \'' . $locale . '\'
            WHERE e.delegation = ' . $delegationId
            );
        return $query->getResult('choicelistCost');
    }

    public function findTranslation($id, $locale)
    {
        if (!$id || !is_string($locale)) {
            return array();
        }
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT e.id, e.expenditure, t.trans as expenditure FROM DelegationsBundle:TypeOfExpenditure e
              LEFT JOIN DelegationsBundle:Translations t WHERE t.hashKey = e.expenditure AND t.locale = \'' . $locale . '\'
            WHERE e.id = ' . $id
            );
        return $query->getResult('choicelistCost');
    }
} 