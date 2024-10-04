<?php

declare(strict_types=1);

namespace Framework\Validator\Field;

use Framework\Validator\Rules\AbstractRule;
use Framework\Validator\Rules\IsNotEmpty;
use Framework\Validator\Rules\IsString;
use Framework\Validator\Rules\IsUrl;

final class Field
{
    private $key;
    private $rules;

    public function __construct(string $key)
    {
        $this->key = $key;
        $this->rules = new FieldRules();
    }

    public static function key(string $key): self
    {
        return new self($key);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getRules(): FieldRules
    {
        return $this->rules;
    }

    public function isNotEmpty(string $message = ''): self
    {
        return $this->add(new IsNotEmpty(), $message);
    }

    private function add(AbstractRule $rule, string $message = ''): self
    {
        $this->rules->add(new FieldRule($rule, $message));

        return $this;
    }

    public function isString(string $message = ''): self
    {
        return $this->add(new IsString(), $message);
    }

    public function isUrl(string $message = ''): self
    {
        return $this->add(new IsUrl(), $message);
    }
}
