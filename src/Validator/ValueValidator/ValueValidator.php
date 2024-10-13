<?php

declare(strict_types=1);

namespace Framework\Validator\ValueValidator;

use Framework\Validator\Rule\BaseRule;
use Framework\Validator\Rule\Collection\IsFloat;
use Framework\Validator\Rule\Collection\IsInt;
use Framework\Validator\Rule\Collection\IsNumber;
use Framework\Validator\Rule\Collection\IsRequired;
use Framework\Validator\Rule\Collection\IsString;
use Framework\Validator\Rule\Collection\IsUrl;
use Framework\Validator\Rule\Rules;

final class ValueValidator
{
    private $rules;

    private function __construct()
    {
        $this->rules = new Rules();
    }

    public static function init(): self
    {
        return new self();
    }

    public function isRequired(string $message = ''): self
    {
        return $this->add(IsRequired::class, $message);
    }

    /**
     * @param class-string<BaseRule> $rule
     * @param string $message
     * @return self
     */
    private function add(string $rule, string $message = ''): self
    {
        $this->rules->add(new $rule($message));

        return $this;
    }

    public function isString(string $message = ''): self
    {
        return $this->add(IsString::class, $message);
    }

    public function isInt(string $message = ''): self
    {
        return $this->add(IsInt::class, $message);
    }

    public function isFloat(string $message = ''): self
    {
        return $this->add(IsFloat::class, $message);
    }

    public function isNumber(string $message = ''): self
    {
        return $this->add(IsNumber::class, $message);
    }

    public function isUrl(string $message = ''): self
    {
        return $this->add(IsUrl::class, $message);
    }

    /**
     * Validates the value with all the specified rules and returns errors if any.
     */
    public function validate($value): ValueValidatorErrors
    {
        $errors = new ValueValidatorErrors();

        $this->rules->each(function (BaseRule $rule) use ($value, $errors): void {
            $result = $rule->validate($value);

            if ($result->isNotPassed()) {
                $errors->add(new ValueValidatorError($rule));
            }
        });

        return $errors;
    }
}
