<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template R
 * @param iterable<R> $collection
 * @param Closure(R,string|int|null):void $fn
 */
function doEach(iterable $collection, Closure $fn): void
{
    foreach($collection as $key => $value) {
        $fn($value, $key);
    }
}
