<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @param array<mixed> ...$arrays
 * @return array<mixed>
 */
function merge(array ...$arrays): array
{
    return array_merge(...$arrays);
}
