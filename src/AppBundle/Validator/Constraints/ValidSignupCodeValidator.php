<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use \DateTimeZone;

class ValidSignupCodeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $reg = $this->getDoctrine()->getRepository('AppBundle:Registration')->findOneBySignupCode($value);
        if(is_null($reg)) {
            $this->context->buildViolation($constraint->messageInvalid)
                ->setParameter('%string%', $value)
                ->addViolation();
        } elseif (date() < $reg->getDateStart()) {
            $this->context->buildViolation($constraint->messageBefore)
                ->setParameter('%string%', $value)
                ->addViolation();
        } elseif(date() > $reg->getDateEnd()) {
            $this->context->buildViolation($constraint->messageAfter)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}