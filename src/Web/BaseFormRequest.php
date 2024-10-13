<?php

declare(strict_types=1);

namespace Framework\Web;

use Framework\Helper\ArrayResolver;
use Framework\Validator\Field\ValidatorFields;
use Framework\Validator\Validator;
use Framework\Web\BaseFormRequest\Field;
use Framework\Web\BaseFormRequest\Fields;
use Framework\Web\BaseFormRequest\ValidatorException;

abstract class BaseFormRequest
{
    /**
     * Validates an array and populates class properties from the array.
     *
     * @throws ValidatorException If validation fails
     */
    public function __construct(array $data = [])
    {
        $this->validate($data);
        $this->fill($data);
    }

    /**
     * Validates an array according to the rules.
     *
     * @throws ValidatorException If validation fails
     */
    private function validate(array $data): void
    {
        $fields = $this->getFields();
        if ($fields->isEmpty()) {
            return;
        }

        $fieldsWithValidators = $fields->filter(function (Field $field) {
            return !is_null($field->toValidatorField());
        });

        $validatorFields = $fieldsWithValidators->map(function (Field $field) {
            return $field->toValidatorField();
        });

        $errors = Validator::validate(new ValidatorFields(...$validatorFields), $data);

        if ($errors->isNotEmpty()) {
            throw ValidatorException::withValidatorErrors($errors);
        }
    }

    /**
     * List of fields for mapping them to class properties.
     *
     * Also, you can add validation to them.
     */
    abstract protected function getFields(): Fields;

    /**
     * Fills the class properties with values from an array.
     */
    private function fill(array $data): void
    {
        $fields = $this->getFields();
        if ($fields->isEmpty()) {
            return;
        }

        $fields->each(function (Field $field) use ($data) {
            $this->{$field->getPropertyName()} = ArrayResolver::from($data, $field->getFieldName());
        });
    }
}
