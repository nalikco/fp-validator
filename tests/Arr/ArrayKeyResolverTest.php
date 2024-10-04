<?php

declare(strict_types=1);

namespace Arr;

use Framework\Arr\ArrayKeyResolver;
use PHPUnit\Framework\TestCase;

final class ArrayKeyResolverTest extends TestCase
{
    public function testResolveValue(): void
    {
        $array = [
            'data' => [
                'user' => [
                    'id' => 1,
                ],
            ],
        ];

        $userId = ArrayKeyResolver::resolve('data.user.id', $array);

        $this->assertEquals($array['data']['user']['id'], $userId);
    }

    public function testNotResolveValue(): void
    {
        $userId = ArrayKeyResolver::resolve('data.user.id', []);

        $this->assertNull($userId);
    }
}
