<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @param    mixed|iterable<mixed> $item
 * @return   iterable<mixed>
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function toIterable(mixed $item): iterable
{
    return match (true) {
        is_iterable($item) => $item,
        default => [$item]
    };
}
