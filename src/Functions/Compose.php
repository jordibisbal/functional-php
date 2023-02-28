<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

function compose(Closure ...$functions): Closure
{
    return foldRight(
        $functions,
        fn($acc, $fn) =>
            static fn ($x) => $acc($fn($x)),
        identity(...)
    );
}
