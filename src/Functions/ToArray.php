<?php

declare(strict_types=1);

namespace j45l\functional;

use Traversable;

/**
 * @param    mixed|iterable<mixed> $item
 * @return   array<mixed>
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function toArray($item): array
{
    switch (true) {
        case $item instanceof Traversable:
            return iterator_to_array($item);
        case is_array($item):
            return $item;
        default:
            return [$item];
    }
}
