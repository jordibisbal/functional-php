<?php

declare(strict_types=1);

namespace j45l\functional\Maybe;

/**
 * @template T
 * @param T $value
 * @return Some<T>
 */
function Some(mixed $value): Some
{
    return Some::of($value);
}

/**
 * @return None<mixed>
 */
function None(): None
{
    return None::create();
}

/**
 * @template T
 * @phpstan-param (T|null) $value
 * @phpstan-return ($value is null ? None<T> : Some<T>)
 */
function Maybe($value): Maybe
{
    return Maybe::ofNullable($value);
}
