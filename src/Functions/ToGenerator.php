<?php

declare(strict_types=1);

namespace j45l\functional;

use Generator;

/**
 * @param iterable<mixed> $iterable
 */
function toGenerator(iterable $iterable): Generator
{
    foreach ($iterable as $key => $value) {
        yield $key => $value;
    }
}
