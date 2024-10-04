<?php

declare(strict_types=1);

namespace Framework\Validator\Rules;

use Framework\Validator\Validation\RuleValidateResult;

final class IsNotEmpty extends AbstractRule
{
    public function validate($value): RuleValidateResult
    {
        $result = !empty($value);

        return new RuleValidateResult($result);
    }
}
