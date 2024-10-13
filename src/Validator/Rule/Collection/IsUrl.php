<?php

declare(strict_types=1);

namespace Framework\Validator\Rule\Collection;

use Framework\Validator\Rule\BaseRule;
use Framework\Validator\Rule\ValidationResult;

final class IsUrl extends BaseRule
{
    public function validate($value): ValidationResult
    {
        $result = filter_var($value, FILTER_VALIDATE_URL) !== false;

        return new ValidationResult($result);
    }

    public function getDefaultErrorMessageString(): string
    {
        return 'Value must be a valid URL';
    }
}
