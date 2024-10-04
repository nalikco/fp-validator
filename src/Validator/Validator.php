<?php

declare(strict_types=1);

namespace Framework\Validator;

use Framework\Arr\ArrayKeyResolver;
use Framework\Validator\Error\ValidationError;
use Framework\Validator\Error\ValidationErrors;
use Framework\Validator\Field\Field;
use Framework\Validator\Field\FieldRule;
use Framework\Validator\Field\Fields;

final class Validator
{
    public static function validate(Fields $fields, array $data): ValidationErrors
    {
        $errors = new ValidationErrors();

        $fields->each(function (Field $field) use ($data, $errors): void {
            $value = ArrayKeyResolver::resolve($field->getKey(), $data);

            $field->getRules()->each(function (FieldRule $fieldRule) use ($value, $errors, $field): void {
                $result = $fieldRule->getRule()->validate($value);

                if ($result->isNotPassed()) {
                    $error = new ValidationError($fieldRule->getMessage(), $field);
                    $errors->add($error);
                }
            });
        });

        return $errors;
    }
}
