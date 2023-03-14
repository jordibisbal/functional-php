<?php

namespace j45l\functional;

use j45l\functional\Tuples\Pair;
use Closure;

/**
 * @param array<mixed> $collections
 * @param null|Closure(mixed, mixed): mixed $productFunction
 * @return array<mixed>
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
  */
function cartesianProduct(array $collections, Closure $productFunction = null): array
{
    $productFunction = $productFunction ?? static fn ($one, $another): Pair => Pair::from($one, $another);
    $cartesianProduct = static fn(array $collections, callable $productFunction) => with(
        ...$collections
    )(static fn ($one, $another) => reduce(
        $one,
        fn($acc, $one) => reduce(
            $another,
            function ($acc, $another) use ($one, $productFunction) {
                return merge($acc, toArray($productFunction($one, $another)));
            },
            $acc
        ),
        []
    ));

    return match (true) {
        count($collections) === 0 => [],
        count($collections) === 1 => toArray(head($collections)),
        default => toArray(($cartesianProduct)(
            /** @phpstan-ignore-next-line */
            [cartesianProduct(butLast($collections), $productFunction), toArray(last($collections))],
            $productFunction
        ))
    };
}
