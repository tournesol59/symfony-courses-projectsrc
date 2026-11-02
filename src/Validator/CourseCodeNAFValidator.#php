<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class CourseCodeNAFValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var CourseCodeNAF $constraint */

        if (null === $value || '' === $value) {
            return;
	}
	
        if (preg_match('/^([a-zA-Z])([a-zA-Z])([a-zA-Z])([0-9])([0-9])([0-9])$/', $value, $matches)) {
           return;
	}

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation()
        ;
    }
}
