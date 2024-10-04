<?php

namespace Framework\Collection;

use ArgumentCountError;
use Generator;
use InvalidArgumentException;

/**
 * @template Key
 * @template Value
 */
class Collection
{
    /** @var array<Key, Value> */
    protected $items = [];

    /**
     * @param Value[] $items
     * @return array<Key, Value>
     */
    final public static function makeItemsWithIds(array $items): array
    {
        $callback = function ($item) {
            return $item->getId();
        };

        $ids = array_map($callback, $items);

        return array_combine($ids, $items);
    }

    /**
     * Is the list not empty?
     *
     * @return bool
     */
    final public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * Is the list empty?
     *
     * @return bool
     */
    final public function isEmpty(): bool
    {
        return $this->getCount() === 0;
    }

    /**
     * The count of items in the list.
     *
     * @return int
     */
    final public function getCount(): int
    {
        return count($this->items);
    }

    /**
     * Returns all items of the list as an array.
     *
     * @return array<Key, Value>
     */
    final public function all(): array
    {
        return $this->items;
    }

    /**
     * Execute a callback over each item.
     *
     * @param callable $callback
     * @return self
     */
    final public function each(callable $callback): self
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * Returns the item with the key.
     *
     * @param Key $key
     * @return Value
     */
    final public function whereKey($key)
    {
        if (!isset($this->items[$key])) {
            throw new InvalidArgumentException('Item not found');
        }

        return $this->items[$key];
    }

    /**
     * Returns the keys of the items.
     *
     * @return Key[]
     */
    final public function getKeys(): array
    {
        return array_keys($this->items);
    }

    /**
     * Run a map over each of the items in the array.
     *
     * @param callable $callback
     * @return array
     */
    final public function map(callable $callback): array
    {
        $keys = array_keys($this->items);

        try {
            $items = array_map($callback, $this->items, $keys);
        } catch (ArgumentCountError $e) {
            $items = array_map($callback, $this->items);
        }

        return array_combine($keys, $items);
    }

    /**
     * Adds an item to a collection
     *
     * @param Value $item
     * @return self
     */
    public function add($item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return Generator
     */
    final public function getList(): Generator
    {
        foreach ($this->items as $item) {
            yield $item;
        }
    }
}