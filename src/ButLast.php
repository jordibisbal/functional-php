<?php

declare(strict_types=1);

namespace j45l\functional;

use function Functional\but_last;

/**
 * @param iterable<mixed> $collection
 * @return array<mixed>
 */
function butLast(iterable $collection): array
{
    return but_last($collection);
}
