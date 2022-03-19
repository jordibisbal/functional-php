<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * Extract a property from a collection of objects.
 *
 * @param iterable<mixed> $collection
 * @param string|array<string> $propertyName
 * @param mixed|null $defaultValue
 * @return array<mixed>
 * @no-named-arguments
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function pluck(iterable $collection, $propertyName, $defaultValue = null): array
{
    $aggregation = [];

    foreach ($collection as $index => $element) {
        $aggregation[$index] = take($element, $propertyName, $defaultValue);
    }

    return $aggregation;
}
