<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param Closure(mixed $value, mixed $initial): mixed $callback
 * @phpstan-param mixed|null $default
 * @return        mixed|null
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function fold(iterable $collection, Closure $callback, mixed $default = null): mixed
{
    return reduce(
        tail($collection),
        /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
        function ($initial, $value) use ($callback) {
            return $callback($value, $initial);
        },
        head($collection)
    ) ?? $default;
}
