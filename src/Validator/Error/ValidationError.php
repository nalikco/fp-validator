<?php

namespace Framework\Validator\Error;

use Framework\Validator\Field\Field;

final class ValidationError
{
    private $message;
    private $field;

    public function __construct(
        string $message,
        Field $field
    ) {
        $this->message = $message;
        $this->field = $field;
    }

    public function getField(): Field
    {
        return $this->field;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
