<?php

declare(strict_types=1);

namespace Framework\Validator\Error;

use Framework\Collection\Collection;

/**
 * @extends Collection<int, ValidatorError>
 */
final class ValidatorErrors extends Collection
{
    public function __construct(ValidatorError ...$items)
    {
        $this->items = $items;
    }
}
