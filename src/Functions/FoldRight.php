<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;
use Traversable;
use function iterator_to_array as iteratorToArray;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param Closure(mixed $value, mixed $initial): mixed $callback
 * @phpstan-param mixed|null $default
 * @return        mixed|null
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function foldRight(iterable $collection, Closure $callback, mixed $default = null): mixed
{
    return fold(
        array_reverse(match (true) {
            $collection instanceof Traversable => iteratorToArray($collection),
            default => $collection,
        }),
        $callback,
        $default
    );
}
