<?php

declare(strict_types=1);

namespace JBFunctional;

use Closure;

function mapOr(callable $callback, callable $failFn = null): Closure
{
    return function (iterable $collection) use ($callback, $failFn): iterable {
        $newCollection = [];

        foreach ($collection as $index => $element) {
            try {
                $newCollection[$index] = $callback($element, $index, $collection);
            } catch (\Throwable $throwable) {
                $newCollection[$index] = $failFn($throwable, $element, $index, $collection);
            }
        }

        return $newCollection;
    };
}
