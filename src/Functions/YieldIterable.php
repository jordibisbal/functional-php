<?php

declare(strict_types=1);

namespace j45l\functional;

use Generator;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function yieldIterable(iterable $collection): Generator
{
    foreach ($collection as $key => $value) {
        yield $key => $value;
    }
}
