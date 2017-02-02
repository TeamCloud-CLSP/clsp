<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidSignupCode extends Constraint
{
    public $messageInvalid = 'The signup code "%string%" is not a valid.';
    public $messageBefore = 'The signup code "%string%" is not yet valid';
    public $messageAfter = 'The signup code "%string%" has expired';
}