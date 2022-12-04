<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either;

/**
 * @param Either<mixed,mixed> $either
 * @return bool
 */
function isSuccess(Either $either): bool
{
    return $either instanceof Success;
}

/**
 * @param Either<mixed,mixed> $either
 * @return bool
 */
function isFailure(Either $either): bool
{
    return $either instanceof Failure;
}