<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidTimezone extends Constraint
{
    public $message = 'The string "%string%" is not a valid IANA Timezone';
}