<?php

namespace j45l\functional;

use JetBrains\PhpStorm\Pure;
use Throwable;

#[Pure] function tryOr(callable $callable, mixed $alternative): mixed
{
    try {
        return $callable();
    } catch (Throwable) {
        return $alternative;
    }
}
