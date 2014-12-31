<?php

namespace Terart\Delegations\DelegationsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DelegationValidator extends ConstraintValidator {
    public function validate($entity, Constraint $constraint)
    {

        $entity->setAdvance(str_replace(',', '.', $entity->getAdvance()));
        if ($entity->getIsPrivateCar() && is_null($entity->getEngineCapacity())) {
            $this->context->buildViolation($constraint->message)
                //->setParameter('%string%', $value)
                ->atPath('engineCapacity')
                ->addViolation();
        }

        if ($entity->getIsPrivateCar() && is_null($entity->getAddress())) {
            $this->context->buildViolation($constraint->message)
                ->atPath('address')
                ->addViolation();
        }

        if ($entity->getIsPrivateCar() && is_null($entity->getCarNumber())) {
            $this->context->buildViolation($constraint->message)
                ->atPath('carNumber')
                ->addViolation();
        }
        if($entity->getTargetCountryType() && $entity->getTargetCountryType()->getId() == 1) {
            $entity->setTargetCountry(null);
        }elseif($entity->getTargetCountryType() == null){
            $this->context->buildViolation($constraint->message)
                //->setParameter('%string%', $value)
                ->atPath('targetCountryType')
                ->addViolation();
        }elseif($entity->getTargetCountry() == null) {
            $this->context->buildViolation($constraint->message)
                //->setParameter('%string%', $value)
                ->atPath('targetCountry')
                ->addViolation();
        }
        if(!$entity->getDateFrom()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('dateFrom')
                ->addViolation();
        }

        if(!$entity->getDateTo()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('dateTo')
                ->addViolation();
        }

        if(!$entity->getType()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('type')
                ->addViolation();
        }
    }
} 