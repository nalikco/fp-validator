<?php

declare(strict_types=1);

namespace Framework\Validator\ValueValidator;

use Framework\Validator\Rule\BaseRule;

final class ValueValidatorError
{
    private $rule;

    public function __construct(
        BaseRule $rule
    ) {
        $this->rule = $rule;
    }

    /**
     * A validation rule that failed.
     */
    public function getRule(): BaseRule
    {
        return $this->rule;
    }
}
