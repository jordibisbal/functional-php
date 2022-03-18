<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param Closure(mixed $value, iterable<mixed> $collection, mixed $folded): mixed $callback
 * @return        mixed|null
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function foldRight(iterable $collection, callable $callback)
{
    $collection = $collection instanceof \Traversable ? iterator_to_array($collection) : $collection;

    return fold(array_reverse($collection), $callback);
}
