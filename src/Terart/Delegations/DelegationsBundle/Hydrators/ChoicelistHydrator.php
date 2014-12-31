<?php

namespace Terart\Delegations\DelegationsBundle\Hydrators;

use Doctrine\ORM\Internal\Hydration\AbstractHydrator;
use PDO;

class ChoicelistHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    private $_idTemplate = array();

    protected function hydrateAllData()
    {
        $result = array();
        $cache = array();
        foreach ($this->_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $this->hydrateRowData($row, $cache, $result);
        }

        return $result;
    }

    protected function hydrateRowData(array $row, array &$cache, array &$result)
    {
        if (count($row) == 0) {
            return false;
        }
        $id = $this->_idTemplate; // initialize the id-memory
        $nonemptyComponents = array();
        $rowData = $this->gatherRowData($row, $cache, $id, $nonemptyComponents);
        if (!isset($rowData['scalars']) || empty($rowData['scalars'])) {
            return false;
        }
        $rowData = $rowData['scalars'];
        $keys = array_keys($rowData);
        $found_index = array_search('hashKey', $keys);
        if ($found_index === false || $found_index === 0) {
            return false;
        }
        unset($rowData['hashKey']);
        $result[$rowData['id']] = $rowData['trans'];
    }
}