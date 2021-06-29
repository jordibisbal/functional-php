<?php

declare(strict_types=1);

namespace JBFunctional;

use Closure;
use Functional\Exceptions\InvalidArgumentException;
use Traversable;

function mapOr(
    callable $callback,
    callable $failFn = null
): Closure {
    return function (Traversable|array $collection) use ($callback, $failFn): Traversable|array {
        InvalidArgumentException::assertCollection($collection, __FUNCTION__, 1);

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
