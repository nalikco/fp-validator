<?php

declare(strict_types=1);

namespace Framework\Validator\Field;

use Framework\Validator\Rules\AbstractRule;

final class FieldRule
{
    private $rule;
    private $message;

    public function __construct(
        AbstractRule $rule,
        string $message = ''
    ) {
        $this->rule = $rule;
        $this->message = $message;
    }

    public function getRule(): AbstractRule
    {
        return $this->rule;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
