<?php

declare(strict_types=1);

namespace j45l\functional;

use function is_iterable as isIterable;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param array<callable(mixed, mixed=, iterable<mixed>=): bool>|null $predicates
 * @phpstan-param array<callable(mixed, mixed=, iterable<mixed>=): bool>|null $mappers
 * @phpstan-return array<mixed>
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
function traverse(iterable $collection, array $predicates = null, array $mappers = null): array
{
    return with(
        first($predicates ?? []) ?? trueFn(...),
        first($mappers ?? []) ?? id(...)
    )(static fn ($currentPredicate, $currentMapper) => reduce(
        $collection,
        fn ($result, $node, $index) => [
            ...$result,
            ...with(
                $currentPredicate($node, $index, $collection),
                tail($predicates ?? [])
            )(static fn (bool $matches, array $predicatesLeft): array => match (true) {
                $matches && empty($predicatesLeft) =>
                    [$index => $currentMapper($node)],
                $matches && isIterable($mappedNode = $currentMapper($node)) =>
                    traverse($mappedNode, $predicatesLeft, tail($mappers ?? [])),
                default => []
            })
        ],
        []
    ));
}
