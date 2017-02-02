<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use \DateTimeZone;

class ValidTimezoneValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if(!in_array($value, DateTimeZone::listIdentifiers())) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}