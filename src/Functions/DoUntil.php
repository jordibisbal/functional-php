<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template R
 * @param Closure():bool $predicate
 * @param (Closure():R)|null $return
 * @phpstan-return ($return is null ? null : R)
 */
function doUntil(Closure $predicate, Closure $fn, Closure $return = null): mixed
{
    do {
        $fn();
    } while (!$predicate());

    return ($return ?? nop(...))();
}
