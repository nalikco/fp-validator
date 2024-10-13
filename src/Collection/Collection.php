<?php

namespace Framework\Collection;

use ArgumentCountError;
use Framework\Helper\ArrayResolver;
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
     */
    final public function each(callable $callback): void
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }
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
     * Sort the collection using the given callback.
     *
     * @param (callable(Value, Key): mixed) $callback
     * @param int $options
     * @param bool $descending
     * @return static<Key, Value>
     */
    final public function sort(callable $callback, int $options = SORT_REGULAR, bool $descending = false)
    {
        $instance = clone $this;

        $results = [];

        foreach ($instance->items as $key => $value) {
            $results[$key] = $callback($value, $key);
        }

        $descending ? arsort($results, $options)
            : asort($results, $options);

        foreach (array_keys($results) as $key) {
            $results[$key] = $instance->items[$key];
        }

        $instance->items = $results;

        return $instance;
    }

    /**
     * Filter the array using the given callback.
     *
     * @param callable $callback
     * @return static<Key, Value>
     */
    public function filter(callable $callback)
    {
        $instance = clone $this;
        $instance->items = array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH);

        return $instance;
    }

    /**
     * Adds an item to a collection
     *
     * @param Value $item
     */
    public function add($item): void
    {
        $this->items[] = $item;
    }

    /**
     * Adds an items to a collection
     *
     * @param Value[] $items
     */
    public function merge(array $items)
    {
        $this->items = array_merge($this->items, $items);
    }

    /**
     * Returns first item of collection
     *
     * @return ?Value
     */
    final public function first()
    {
        return current($this->items) ?? null;
    }

    /**
     * Returns the key value of an element.
     *
     * If items is objects example: key is 'id' = $item->getId()
     *
     * If items is arrays example: key is 'user.id' = $item['user']['id']
     */
    final public function column(string $key): Collection
    {
        $items = $this->map(function ($item) use ($key) {
            if (is_array($item)) {
                return ArrayResolver::from($item, $key);
            } elseif (is_object($item)) {
                $getterMethodName = 'get' . lcfirst($key);

                if (method_exists($item, $getterMethodName)) {
                    return $item->{$getterMethodName}();
                }
            }

            return null;
        });

        $instance = new self();
        $instance->items = array_values($items);

        return $instance;
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
}
