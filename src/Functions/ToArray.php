<?php

declare(strict_types=1);

namespace j45l\functional;

use Traversable;

/**
 * @template T
 * @param    T|\Traversable<T> $item
 * @return   array<T>
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function toArray(mixed $item): array
{
    return match (true) {
        $item instanceof Traversable => iterator_to_array($item),
        is_array($item) => $item,
        default => [$item],
    };
}
