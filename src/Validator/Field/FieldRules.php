<?php

declare(strict_types=1);

namespace Framework\Validator\Field;

use Framework\Collection\Collection;

final class FieldRules extends Collection
{
    public function __construct(FieldRule ...$items)
    {
        $this->items = $items;
    }
}
