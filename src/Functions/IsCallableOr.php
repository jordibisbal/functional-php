<?php

declare(strict_types=1);

namespace j45l\functional;

use function is_callable as isCallable;

function isCallableOr(mixed $target, callable $default = null): callable|null
{
    return isCallable($target) ? $target : $default;
}
