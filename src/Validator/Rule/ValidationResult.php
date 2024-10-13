<?php

declare(strict_types=1);

namespace Framework\Validator\Rule;

final class ValidationResult
{
    private $passed;

    public function __construct(bool $passed)
    {
        $this->passed = $passed;
    }

    /**
     * Has it been failed?
     */
    public function isNotPassed(): bool
    {
        return !$this->isPassed();
    }

    /**
     * Has it been validated?
     */
    public function isPassed(): bool
    {
        return $this->passed;
    }
}
