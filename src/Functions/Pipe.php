<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

function pipe(Closure ...$functions): mixed
{
    return match (true) {
        count($functions) > 0 =>
            fold(
                tail($functions),
                fn($acc, $item) => static fn($x) => $item($acc($x)),
                identity(...)
            )(head($functions)()),
        default => null,
    };
}
