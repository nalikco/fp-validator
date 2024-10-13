<?php

declare(strict_types=1);

namespace Framework\Validator\Rule\Collection;

use Framework\Validator\Rule\BaseRule;
use Framework\Validator\Rule\ValidationResult;

final class IsFloat extends BaseRule
{
    public function validate($value): ValidationResult
    {
        $result = is_float($value);

        return new ValidationResult($result);
    }

    public function getDefaultErrorMessageString(): string
    {
        return 'Value must be a float';
    }
}
