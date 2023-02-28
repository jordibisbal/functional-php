<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

use function array_merge as arrayMerge;

function partial(Closure $fn, mixed ...$arguments): Closure
{
    return static fn(...$innerArguments) => $fn(...$arguments, ...$innerArguments);
}
