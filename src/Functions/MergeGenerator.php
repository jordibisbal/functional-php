<?php

declare(strict_types=1);

namespace j45l\functional;

use Generator;

/** @param Generator|array<mixed> ...$generators */
function mergeGenerator(Generator|array ...$generators): Generator
{
    foreach ($generators as $generator) {
        foreach ($generator as $value) {
            yield $value;
        }
    }
}
