<?php

declare(strict_types=1);

namespace j45l\functional;

use function is_a as isA;

/**
 * @template T
 * @param class-string<T> $className
 * @return T
 */
function isAOr(mixed $target, string $className, mixed $default): mixed
{
    return isA($target, $className) ? $target : $default;
}
