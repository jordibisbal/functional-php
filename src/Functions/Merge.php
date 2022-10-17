<?php

declare(strict_types=1);

namespace j45l\functional;

use Generator;

/**
 * @phpstan-param iterable<iterable<mixed>> $generators
 * @return        Generator
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function merge(...$generators): Generator
{
    foreach ($generators as $generator) {
        foreach ($generator as $value) {
            yield $value;
        }
    }
}
