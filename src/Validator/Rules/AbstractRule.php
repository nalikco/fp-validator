<?php

declare(strict_types=1);

namespace Framework\Validator\Rules;

use Framework\Validator\Validation\RuleValidateResult;

abstract class AbstractRule
{
    abstract public function validate($value): RuleValidateResult;
}
