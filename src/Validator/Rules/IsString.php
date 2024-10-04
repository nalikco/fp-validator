<?php

declare(strict_types=1);

namespace Framework\Validator\Rules;

use Framework\Validator\AbstractRule;
use Framework\Validator\Validation\RuleValidateResult;

final class IsString extends AbstractRule
{
    public function validate($value): RuleValidateResult
    {
        $result = is_string($value);

        return new RuleValidateResult($result);
    }
}
