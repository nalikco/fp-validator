<?php

declare(strict_types=1);

namespace Validator\Rules;

use Framework\Validator\Rule\Collection\IsRequired;
use PHPUnit\Framework\TestCase;

final class IsRequiredTest extends TestCase
{
    public function testPassed(): void
    {
        $rule = new IsRequired();

        $values = [
            'not_empty',
            true,
            1,
            [1],
        ];

        foreach ($values as $value) {
            $result = $rule->validate($value);

            $this->assertTrue($result->isPassed());
        }
    }

    public function testNotPassed(): void
    {
        $rule = new IsRequired();

        $values = [
            '',
            false,
            null,
            0,
            [],
        ];

        foreach ($values as $value) {
            $result = $rule->validate($value);

            $this->assertFalse($result->isPassed());
        }
    }
}
