<?php

declare(strict_types=1);

namespace Validator\Rules;

use Framework\Validator\Rules\IsString;
use PHPUnit\Framework\TestCase;

final class IsStringTest extends TestCase
{
    public function testPassed(): void
    {
        $rule = new IsString();

        $result = $rule->validate('string');

        $this->assertTrue($result->isPassed());
    }

    public function testNotPassed(): void
    {
        $rule = new IsString();

        $values = [
            0,
            false,
            null,
            [],
            new IsString(),
        ];

        foreach ($values as $value) {
            $result = $rule->validate($value);

            $this->assertFalse($result->isPassed());
        }
    }
}
