<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @param array<mixed> $collections
 * @return array<mixed>
 */
function zip(array $collections, callable $interlaceFn = null): array
{
    $interlaceFn ??= static fn (...$items) => $items;

    return with(reduce(
        $collections,
        fn ($acc, $collection) => array_unique([...$acc, ...array_keys($collection)]),
        []
    ))(static fn (array $indices) => reduce(
        $indices,
        fn ($acc, $index) => array_merge(
            $acc,
            [$index => $interlaceFn(
                ...reduce(
                    $collections,
                    fn ($acc, $collection) => [...$acc, $collection[$index] ?? null],
                    []
                )
            )]
        ),
        []
    ));
}
