<?php

declare(strict_types=1);

namespace JBFunctional;

use Functional\Exceptions\InvalidArgumentException;
use Traversable;

function mapOr(
    Traversable|array $collection,
    callable $callback,
    callable $failFn = null
): array {
    InvalidArgumentException::assertCollection($collection, __FUNCTION__, 1);

    $aggregation = [];

    foreach ($collection as $index => $element) {
        try {
            $aggregation[$index] = $callback($element, $index, $collection);
        } catch (\Throwable $throwable) {
            $aggregation[$index] = $failFn($throwable, $element, $index, $collection);
        }
    }

    return $aggregation;
}
