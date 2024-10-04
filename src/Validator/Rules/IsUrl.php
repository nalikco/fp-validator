<?php

declare(strict_types=1);

namespace Framework\Validator\Rules;

use Framework\Validator\AbstractRule;
use Framework\Validator\Validation\RuleValidateResult;

final class IsUrl extends AbstractRule
{
    public function validate($value): RuleValidateResult
    {
        $result = filter_var($value, FILTER_VALIDATE_URL) !== false;

        return new RuleValidateResult($result);
    }
}
