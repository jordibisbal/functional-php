<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T of object
 * @param T $object
 * @param Closure(T):void $callable
 * @return T
 */
function cloneWith(object $object, Closure $callable): object
{
    $new = clone $object;

    $callable->bindTo($new, $new)($new);
    return $new;
}
