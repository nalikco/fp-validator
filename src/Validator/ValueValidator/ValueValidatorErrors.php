<?php

declare(strict_types=1);

namespace Framework\Validator\ValueValidator;

use Framework\Collection\Collection;

/**
 * @extends Collection<int, ValueValidatorError>
 */
final class ValueValidatorErrors extends Collection
{
    public function __construct(ValueValidatorError ...$items)
    {
        $this->items = $items;
    }
}
