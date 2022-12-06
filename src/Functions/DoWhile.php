<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template TResult
 * @param callable():bool $predicate
 * @param callable():TResult|null $else
 * @return TResult
 */
function doWhile(callable $predicate, callable $fn, callable $else = null): mixed
{
    while ($predicate()) {
        $fn();
    }

    return ($else ?? nop(...))();
}
