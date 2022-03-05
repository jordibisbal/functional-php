<?php

namespace j45l\functional;

use Throwable;

function tryOr(callable $callable, mixed $alternative): mixed
{
    try {
        return $callable();
    } catch (Throwable) {
        return $alternative;
    }
}
