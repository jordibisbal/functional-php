<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either;

function isSuccess(mixed $either): bool
{
    return $either instanceof Success;
}

function isEither(mixed $either): bool
{
    return $either instanceof Either;
}

function isFailure(mixed $either): bool
{
    return $either instanceof Failure;
}