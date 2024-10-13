<?php

declare(strict_types=1);

namespace Framework\Validator\Rule;

use Framework\Collection\Collection;

/**
 * @extends Collection<int, BaseRule>
 */
final class Rules extends Collection
{
    public function __construct(BaseRule ...$items)
    {
        $this->items = $items;
    }
}
