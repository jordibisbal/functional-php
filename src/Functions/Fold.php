<?php

declare(strict_types=1);

namespace j45l\functional;

use function Functional\head;
use function Functional\tail;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param callable(mixed $value, mixed $initial): mixed $callback
 * @phpstan-param mixed|null $default
 * @return        mixed|null
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function fold(iterable $collection, callable $callback, $default = null)
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
