<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @param mixed $value
 * @return Closure
 */
function value(mixed $value): Closure
{
    return static function () use ($value) {
        return $value;
    };
}
