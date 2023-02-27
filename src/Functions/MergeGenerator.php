<?php

declare(strict_types=1);

namespace j45l\functional;

use Generator;

/** @param Generator|array<mixed> ...$collections */
function mergeGenerator(Generator|array ...$collections): Generator
{
    foreach ($collections as $collection) {
        foreach ($collection as $key => $value) {
            yield $key => $value;
        }
    }
}
