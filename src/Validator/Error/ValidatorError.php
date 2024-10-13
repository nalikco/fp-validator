<?php

namespace Framework\Validator\Error;

use Framework\Validator\Rule\BaseRule;

final class ValidatorError
{
    private $fieldName;
    private $rule;

    public function __construct(
        string $fieldName,
        BaseRule $rule
    ) {
        $this->fieldName = $fieldName;
        $this->rule = $rule;
    }

    /**
     * Returns the key of a value in an array.
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * A validation rule that failed.
     */
    public function getRule(): BaseRule
    {
        return $this->rule;
    }
}
