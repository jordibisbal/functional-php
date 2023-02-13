<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

function isClosureOr(mixed $target, Closure $default = null): Closure|null
{
    return $target instanceof Closure ? $target : $default;
}
