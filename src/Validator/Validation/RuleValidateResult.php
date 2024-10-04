<?php

declare(strict_types=1);

namespace Framework\Validator\Validation;

final class RuleValidateResult
{
    private $passed;

    public function __construct(bool $passed)
    {
        $this->passed = $passed;
    }

    public function isNotPassed(): bool
    {
        return !$this->isPassed();
    }

    public function isPassed(): bool
    {
        return $this->passed;
    }
}
