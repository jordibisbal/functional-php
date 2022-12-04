<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template TResult
 * @param callable():bool $predicate
 * @param callable():TResult $else
 * @return TResult
 */
function doWhile(callable $predicate, callable $fn, callable $else): mixed
{
    while ($predicate()) {
        $fn();
    }

    return $else();
}
