<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Maybe;

/**
 * @param Maybe<mixed> $maybe
 * @return bool
 */
function isSome(Maybe $maybe): bool
{
    return $maybe instanceof Some;
}

/**
 * @param Maybe<mixed> $maybe
 * @return bool
 */
function isNone(Maybe $maybe): bool
{
    return $maybe instanceof None;
}
