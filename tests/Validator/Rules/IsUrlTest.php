<?php

declare(strict_types=1);

namespace Validator\Rules;

use Framework\Validator\Rule\Collection\IsUrl;
use PHPUnit\Framework\TestCase;

final class IsUrlTest extends TestCase
{
    public function testPassed(): void
    {
        $rule = new IsUrl();

        $result = $rule->validate('https://google.com');

        $this->assertTrue($result->isPassed());
    }

    public function testNotPassed(): void
    {
        $rule = new IsUrl();

        $values = [
            0,
            false,
            null,
            [],
            'not_url',
            'google.com',
        ];

        foreach ($values as $value) {
            $result = $rule->validate($value);

            $this->assertFalse($result->isPassed());
        }
    }
}
