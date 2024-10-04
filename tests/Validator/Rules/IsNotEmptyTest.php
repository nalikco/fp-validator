<?php

declare(strict_types=1);

namespace Validator\Rules;

use Framework\Validator\Rules\IsNotEmpty;
use PHPUnit\Framework\TestCase;

final class IsNotEmptyTest extends TestCase
{
    public function testPassed(): void
    {
        $rule = new IsNotEmpty();

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
        $rule = new IsNotEmpty();

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
