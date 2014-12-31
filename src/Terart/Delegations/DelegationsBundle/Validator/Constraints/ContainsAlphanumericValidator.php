<?php

namespace Terart\Delegations\DelegationsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsAlphanumericValidator extends ConstraintValidator {
    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/^[a-zA-Z\_\-0-9\/]+$/', $value, $matches)) {
            // If you're using the new 2.5 validation API (you probably are!)
            $this->context->buildViolation($constraint->message)
                //->setParameter('%string%', $value)
                ->addViolation();

            // If you're using the old 2.4 validation API
            /*
            $this->context->addViolation(
                $constraint->message,
                array('%string%' => $value)
            );
            */
        }
    }
} 