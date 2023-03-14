<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

function partial(Closure $fn, mixed ...$arguments): Closure
{
    return static fn(...$innerArguments) => $fn(...$arguments, ...$innerArguments);
}
