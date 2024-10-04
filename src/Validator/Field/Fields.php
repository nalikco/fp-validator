<?php

declare(strict_types=1);

namespace Framework\Validator\Field;

use Framework\Collection\Collection;

final class Fields extends Collection
{
    public function __construct(Field ...$items)
    {
        $this->items = $items;
    }
}
