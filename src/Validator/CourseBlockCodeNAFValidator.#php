<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class CourseBlockCodeNAFValidator extends ConstraintValidator
{
    private CourseRepository $courseRepository;

    public function __contruct(CourseRepository $courseRepository) {
        $this->courseRepository=$courseRepository;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var CourseBlockCodeNAF $constraint */

        if (null === $value || '' === $value) {
            return;
	}
	
	if (preg_match('/^([a-zA-Z])([a-zA-Z])([a-zA-Z])([0-9])([0-9])([0-9])$/', $value, $matches)) {
		if ($this->courseRepository->findOneByCodeNAF($value) != Null)
                    return;
	}
        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation()
        ;
    }
}
