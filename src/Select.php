<?php


namespace Functional;

/**
 * based on Functional-php by Lars Strojny <lstrojny@php.net> / https://github.com/lstrojny/functional-php
 */
function select(iterable $collection, callable $callback = null): array
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
