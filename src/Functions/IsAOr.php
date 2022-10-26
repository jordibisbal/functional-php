<?php

declare(strict_types=1);

namespace j45l\functional;

use function is_a as isA;

/**
 * @template T
 * @template T2
 * @param class-string<T> $className
 * @param T2|null $default
 * @return T|T2|null
 */
function isAOr(mixed $target, string $className, mixed $default = null): mixed
{
    return isA($target, $className) ? $target : $default;
}
