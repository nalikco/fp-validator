<?php

declare(strict_types=1);

namespace Framework\Validator\Rule;

abstract class BaseRule
{
    private $providedErrorMessage;

    public function __construct(
        string $providedErrorMessage = ''
    ) {
        $this->providedErrorMessage = $providedErrorMessage;
    }

    /**
     * Validates the value
     */
    abstract public function validate($value): ValidationResult;

    /**
     * Returns the error that occurred during validation
     */
    public function getErrorMessage(): ErrorMessage
    {
        if (!empty($this->providedErrorMessage)) {
            return new ErrorMessage($this->providedErrorMessage);
        }

        return new ErrorMessage($this->getDefaultErrorMessageString());
    }

    /**
     * Returns the error message that will be returned if no error message is specified
     */
    abstract public function getDefaultErrorMessageString(): string;
}
