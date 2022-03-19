<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param callable(mixed $value, mixed $initial): mixed $callback
 * @return        mixed|null
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function foldRight(iterable $collection, callable $callback)
{
    $collection = $collection instanceof \Traversable ? iterator_to_array($collection) : $collection;

    return fold(array_reverse($collection), $callback);
}
