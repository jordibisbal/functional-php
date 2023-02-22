<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

function isClosureOr(mixed $value, Closure $default = null): Closure
{
    $default ??= nop(...);

    return $value instanceof Closure ? $value : $default;
}
