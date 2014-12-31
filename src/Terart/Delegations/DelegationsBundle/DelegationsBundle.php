<?php

namespace Terart\Delegations\DelegationsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DelegationsBundle extends Bundle
{

    public function boot()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $em->getConfiguration()->setCustomHydrationModes(
            array('translations' => '\Terart\Delegations\DelegationsBundle\Hydrators\TranslationsHydrator',
                'choicelistCost' => '\Terart\Delegations\DelegationsBundle\Hydrators\ChoicelistCostHydrator',
                'choicelist' => '\Terart\Delegations\DelegationsBundle\Hydrators\ChoicelistHydrator'
            )
        );

    }
}