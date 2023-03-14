<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

use function is_iterable as isIterable;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param array<array{
 *         0?:(Closure(mixed $value, mixed $key, iterable<mixed> $collection):bool),
 *         1?:(Closure(mixed $value, array<string|int> $path,iterable<mixed> $collection):mixed)
 *     }> $mapSelect
 * @phpstan-return array<mixed>
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
function traverse(iterable $collection, array $mapSelect): array
{
    return ($traverse =
        static function (iterable $branch, array $mapSelect, array $path) use (&$traverse, $collection) {
            return with(
                first($mapSelect)[0] ?? trueFn(...),
                first($mapSelect)[1] ?? identity(...),
                tail($mapSelect)
            )(static fn($currentPredicate, $currentMapper, $mapSelectLeft) => reduce(
                $branch,
                fn($projections, $node, $index) => [
                    ...$projections,
                    ...!$currentPredicate($node, $index, $branch)
                        ? []
                        : match (true) {
                            empty($mapSelectLeft) => [$index => $currentMapper($node, $path, $collection)],
                            isIterable($mappedNode = $currentMapper($node, $path, $collection)) =>
                                $traverse($mappedNode, $mapSelectLeft, [...$path, $index]),
                            default => []
                        }
                ],
                []
            ));
        }
    )($collection, $mapSelect, []);
}
