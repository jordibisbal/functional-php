<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T of object
 * @param T $object
 * @param Closure(mixed):mixed $closure
 * @return T
 */
function cloneWith(object $object, Closure $closure): object
{
    $new = clone $object;

    $closure->bindTo($new, $new)($new);
    return $new;
}
