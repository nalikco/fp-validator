<?php

declare(strict_types=1);

namespace Framework\Web\BaseFormRequest;

use Framework\Collection\Collection;

/**
 * @extends Collection<int, Field>
 */
class Fields extends Collection
{
    public function __construct(Field ...$items)
    {
        $this->items = $items;
    }
}
