<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template R
 * @param Closure():bool $predicate
 * @param Closure():R|null $onFinish
 * @phpstan-return ($onFinish is null ? null : R)
 */
function doWhile(Closure $predicate, Closure $fn, Closure $onFinish = null): mixed
{
    while ($predicate()) {
        $fn();
    }

    return ($onFinish ?? nop(...))();
}
