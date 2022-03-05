<?php

declare(strict_types=1);

namespace j45l\functional;

use JetBrains\PhpStorm\Pure;

/**
 * based on Functional-php by Lars Strojny <lstrojny@php.net> / https://github.com/lstrojny/functional-php
 * @phpstan-ignore-next-line
 */
#[Pure] function filter(iterable $collection, callable $callback = null): array
{
    return select($collection, $callback);
}
