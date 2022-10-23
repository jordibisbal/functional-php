<?php

namespace j45l\functional;

use function Functional\but_last;
use function Functional\head;
use function Functional\last;

/**
 * @param array<mixed> $vectors
 * @param null|callable(mixed, mixed): mixed $productFunction
 * @return array<mixed>
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
  */
function cartesianProduct(array $vectors, callable $productFunction = null): array
{
    $productFunction = $productFunction ?? function ($one, $another): Pair {
        return Pair::from($one, $another);
    };

    $cartesianProduct = static function (array $vectors, callable $productFunction) {
        [$one, $another] = $vectors;
        return reduce(
            $one,
            /**  @SuppressWarnings(PHPMD.UnusedFormalParameter) */
            function ($acc, $one) use ($productFunction, $another) {
                return reduce(
                    $another,
                    function ($acc, $another) use ($one, $productFunction) {
                        return merge($acc, toIterable($productFunction($one, $another)));
                    },
                    $acc
                );
            },
            []
        );
    };

    return match (true) {
        count($vectors) === 0 => [],
        count($vectors) === 1 => toArray(reduce(
            head($vectors),
            function ($acc, $item) {
                return merge($acc, toIterable($item));
            },
            []
        )),
        default=> toArray(($cartesianProduct)(
            [cartesianProduct(but_last($vectors), $productFunction), toArray(last($vectors))],
            $productFunction
        ))
    };
}
