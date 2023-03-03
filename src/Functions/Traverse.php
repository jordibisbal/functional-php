<?php

declare(strict_types=1);

namespace j45l\functional;

use function is_iterable as isIterable;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param array<array{
 *         0:(callable(mixed,mixed,iterable<mixed>):bool),
 *         1?:callable(mixed,mixed,iterable<mixed>):bool
 *     }> $queries
 * @phpstan-return array<mixed>
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
function traverse(iterable $collection, array $queries): array
{
    return with(
        first($queries)[0] ?? trueFn(...),
        first($queries)[1] ?? identity(...),
        tail($queries)
    )(static fn ($currentPredicate, $currentMapper, $queriesLeft) => reduce(
        $collection,
        fn ($projections, $node, $index) => [
            ...$projections,
            ...!$currentPredicate($node, $index, $collection) ? [] : match (true) {
                empty($queriesLeft) =>
                    [$index => $currentMapper($node)],
                isIterable($mappedNode = $currentMapper($node)) =>
                    traverse($mappedNode, $queriesLeft),
                default =>
                    []
            }
        ],
        []
    ));
}
