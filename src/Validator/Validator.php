<?php

declare(strict_types=1);

namespace Framework\Validator;

use Framework\Helper\ArrayResolver;
use Framework\Validator\Error\ValidatorError;
use Framework\Validator\Error\ValidatorErrors;
use Framework\Validator\Field\ValidatorField;
use Framework\Validator\Field\ValidatorFields;
use Framework\Validator\ValueValidator\ValueValidatorError;

final class Validator
{
    /**
     * Validates an array according to the given rules
     */
    public static function validate(ValidatorFields $fields, array $data): ValidatorErrors
    {
        $errors = new ValidatorErrors();

        $fields->each(function (ValidatorField $field) use ($data, $errors): void {
            $value = ArrayResolver::from($data, $field->getFieldName());

            $fieldErrors = $field->getValueValidator()->validate($value);

            $errors->merge($fieldErrors->map(function (ValueValidatorError $error) use ($field): ValidatorError {
                return new ValidatorError($field->getFieldName(), $error->getRule());
            }));
        });

        return $errors;
    }
}
