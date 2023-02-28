<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

function pipe(Closure ...$functions): mixed
{
    return compose(...$functions)(null);
}
