<?php

declare(strict_types=1);

namespace Framework\Validator\Error;

use Framework\Collection\Collection;

final class ValidationErrors extends Collection
{
    public function __construct(ValidationError ...$items)
    {
        $this->items = $items;
    }
}
