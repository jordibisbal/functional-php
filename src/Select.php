<?php

declare(strict_types=1);

namespace j45l\functional;

use JetBrains\PhpStorm\Pure;

/**
 * based on Functional-php by Lars Strojny <lstrojny@php.net> / https://github.com/lstrojny/functional-php
 * @phpstan-ignore-next-line
 */
#[Pure] function select(iterable $collection, callable $callback = null): array
{
    $aggregation = [];

    if ($callback === null) {
        $callback = '\Functional\id';
    }

    foreach ($collection as $index => $element) {
        if ($callback($element, $index, $collection)) {
            $aggregation[$index] = $element;
        }
    }

    return $aggregation;
}
