<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @param    mixed|iterable<mixed> $item
 * @return   iterable<mixed>
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function toIterable($item): iterable
{
    switch (true) {
        case is_iterable($item):
            return $item;
        default:
            return [$item];
    }
}
