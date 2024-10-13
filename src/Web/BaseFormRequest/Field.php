<?php

declare(strict_types=1);

namespace Framework\Web\BaseFormRequest;

use Framework\Validator\Field\ValidatorField;
use Framework\Validator\ValueValidator\ValueValidator;

class Field
{
    private $propertyName;
    private $fieldName;
    private $valueValidator;

    public function __construct(
        string $propertyName,
        string $fieldName,
        ?ValueValidator $valueValidator = null
    ) {
        $this->propertyName = $propertyName;
        $this->fieldName = $fieldName;
        $this->valueValidator = $valueValidator;
    }

    public function toValidatorField(): ?ValidatorField
    {
        if (is_null($this->getValueValidator())) {
            return null;
        }

        return new ValidatorField($this->getFieldName(), $this->getValueValidator());
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
    public function getValueValidator(): ?ValueValidator
    {
        return $this->valueValidator;
    }

    /**
     * Returns the name of the class property.
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }
}
