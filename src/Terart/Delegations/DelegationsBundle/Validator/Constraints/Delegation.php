<?php

namespace Terart\Delegations\DelegationsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class Delegation extends Constraint {
    //public $message = 'The string "%string%" contains an illegal character: it can only contain letters or numbers.';
    public $message = 'translations.engineCapacityErrMsg';

    public function validatedBy()
    {
        //return get_class($this).'Validator';
        return 'delegation';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

} 