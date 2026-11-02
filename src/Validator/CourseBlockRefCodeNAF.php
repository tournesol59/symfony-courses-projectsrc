<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CourseBlockRefCodeNAF extends Constraint
{
    public string $message = 'The string "{{ string }}" does not represent a code of a course belonging to the current CourseBlock';
    public string $mode = 'strict';

    // all configurable options must be passed to the constructor
    public function __construct(?string $mode = null, ?string $message = null, ?array $groups = null, $payload = null)
    {
        $this->mode = $mode ?? $this->mode;
        $this->message = $message ?? $this->message;

        parent::__construct(null, $groups, $payload);
    }
}
