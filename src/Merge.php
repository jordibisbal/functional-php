<?php

namespace j45l\functional;

use Traversable;

/**
 * @param        mixed $first
 * @param        mixed $second
 * @return       array<mixed>
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function merge($first, $second): array
{
    $toArray = function ($item): array {
        switch (true) {
            case $item instanceof Traversable:
                return iterator_to_array($item);
            case is_array($item):
                return $item;
            default:
                return [$item];
        }
    };

    return array_merge($toArray($first), $toArray($second));
}
