<?php

declare(strict_types=1);

namespace JBFunctional;

use Closure;

function mapOr(callable $fn, callable $failFn = null): Closure
{
    return function (iterable $collection) use ($fn, $failFn): iterable {
        $newCollection = [];

        foreach ($collection as $index => $element) {
            try {
                $newCollection[$index] = $fn($element, $index, $collection);
            } catch (\Throwable $throwable) {
                $newCollection[$index] = $failFn($throwable, $element, $index, $collection);
            }
        }

        return $newCollection;
    };
}
