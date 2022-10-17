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

    $cartesianProduct = function (array $vectors, callable $productFunction) {
        [$one, $another] = $vectors;
        return reduce(
            $one,
            /**  @SuppressWarnings(PHPMD.UnusedFormalParameter) */
            function ($one, $_1, $_2, $acc) use ($productFunction, $another) {
                return reduce(
                    $another,
                    function ($another, $_1, $_2, $acc) use ($one, $productFunction) {
                        return merge($acc, toIterable($productFunction($one, $another)));
                    },
                    $acc
                );
            },
            []
        );
    };

    switch (true) {
        case count($vectors) === 0:
            return [];
        case count($vectors) === 1:
            return toArray(reduce(
                head($vectors),
                /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
                function ($item, $_1, $_2, $acc) {
                    return merge($acc, toIterable($item));
                },
                []
            ));
        default:
            return toArray(($cartesianProduct)(
                [cartesianProduct(but_last($vectors), $productFunction), toArray(last($vectors))],
                $productFunction
            ));
    }
}
