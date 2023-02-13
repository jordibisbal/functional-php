<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

function isClosureOr(mixed $target, Closure $default = null): callable|null
{
    return $target instanceof Closure ? $target : $default;
}
