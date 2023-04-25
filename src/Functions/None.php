<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param Closure(mixed $value, mixed $index, mixed $collection): bool $predicate
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function none(iterable $collection, Closure $predicate = null): bool
{
    $predicate ??= static fn ($x) => (bool) $x;

    foreach ($collection as $index => $value) {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        if ($predicate($value, $index, $collection)) {
            return false;
        }
    }

    return true;
}
