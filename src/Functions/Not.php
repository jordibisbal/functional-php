<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @return Closure(mixed...):bool
 */
function not(Closure $fn): Closure
{
    return static fn (...$arguments) => !$fn(...$arguments);
}
