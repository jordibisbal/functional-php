<?php

namespace j45l\functional;

use j45l\functional\Tuples\Pair;
use Closure;
use function array_values as arrayValues;

/**
 * @param array<mixed> $collections
 * @param null|Closure(mixed, mixed): mixed $productFunction
 * @return array<mixed>
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
  */
function cartesianProduct(array $collections, Closure $productFunction = null): array
{
    $productFunction = $productFunction ?? static fn ($one, $another): Pair => Pair::from($one, $another);
    $product = static fn ($first, $second) => reduce(
        $first,
        fn ($acc, $element) =>
            [...$acc, ...map($second, fn ($secondElement) => $productFunction($element, $secondElement))],
        []
    );
    $normalize = static fn (array $collection) => arrayValues(toArray($collection));

    return match (true) {
        count($collections) === 0 => [],
        count($collections) === 1 => toArray(head($collections)),
        count($collections) === 2 => with(...$collections)(
            static fn ($first, $second) => $product($normalize($first), $normalize($second))
        ),
        default => cartesianProduct(
            /** @phpstan-ignore-next-line */
            [head($collections), cartesianProduct(tail($collections), $productFunction)],
            $productFunction
        )
    };
}
