<?php

use function Functional\but_last;
use function Functional\head;
use function Functional\last;
use function j45l\functional\merge;
use function j45l\functional\reduce;

/**
 * @param        array<mixed> $vectors
 * @return       array<mixed>|null
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
  */
function cartesianProduct(array $vectors, Closure $productFunction): ?array
{
    $vectorTwoCartesianProduct = function (array $vectors, Closure $productFunction) {
        return reduce(
            head($vectors),
            /**  @SuppressWarnings(PHPMD.UnusedFormalParameter) */
            function ($one, $_1, $_2, $acc) use ($productFunction, $vectors) {
                return reduce(
                    last($vectors),
                    function ($another, $_1, $_2, $acc) use ($one, $productFunction) {
                        return merge($acc, $productFunction($one, $another));
                    },
                    $acc
                );
            },
            []
        );
    };

    switch (true) {
        case count($vectors) === 0:
            return null;
        case count($vectors) === 1:
            return reduce(
                head($vectors),
                /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
                function ($item, $_1, $_2, $acc) {
                    return merge($acc, $item);
                },
                []
            );
        case count($vectors) === 2:
            return $vectorTwoCartesianProduct($vectors, $productFunction);
        default:
            return $vectorTwoCartesianProduct(
                [cartesianProduct(but_last($vectors), $productFunction), last($vectors)],
                $productFunction
            );
    }
}
