<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template T
 * @param T $x
 * @return T
 */
function identity(mixed $x): mixed
{
    return $x;
}
