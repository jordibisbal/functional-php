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
    return match (true) {
        $item instanceof Traversable => iterator_to_array($item),
        is_array($item) => $item,
        default => [$item],
    };
}
