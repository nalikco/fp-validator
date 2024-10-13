<?php

declare(strict_types=1);

namespace Framework\Validator\Field;

use Framework\Validator\ValueValidator\ValueValidator;

final class ValidatorField
{
    private $fieldName;
    private $valueValidator;

    public function __construct(
        string $fieldName,
        ValueValidator $valueValidator
    ) {
        $this->fieldName = $fieldName;
        $this->valueValidator = $valueValidator;
    }

    /**
     * Returns the key of a value in an array.
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * Returns a value validator with rules.
     */
    public function getValueValidator(): ValueValidator
    {
        return $this->valueValidator;
    }
}
