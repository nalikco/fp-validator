<?php

declare(strict_types=1);

namespace Framework\Validator\Field;

use Framework\Collection\Collection;

/**
 * @extends Collection<int, ValidatorField>
 */
final class ValidatorFields extends Collection
{
    public function __construct(ValidatorField ...$items)
    {
        $this->items = $items;
    }
}
