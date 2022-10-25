<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @param    array<mixed> $collection
 * @return   array{mixed, mixed}
 */
function unzip(array $collection, mixed $defaultLeft = null, mixed $defaultRight = null): array
{
    $defaultRight ??= $defaultLeft;

    return reduce(
        $collection,
        fn ($initial, $item) =>
        [
            [...$initial[0], $item[0] ?? $defaultLeft],
            [...$initial[1], $item[1] ?? $defaultRight]
        ],
        [[],[]]
    );
}
