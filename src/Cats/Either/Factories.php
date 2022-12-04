<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either;

use Exception;
use j45l\functional\Cats\Either\Reason\Because;
use j45l\functional\Cats\Either\Reason\BecauseException;
use j45l\functional\Cats\Either\Reason\BecauseNull;
use j45l\functional\Cats\Either\Reason\Reason;

/**
 * @template T
 * @param T $value
 * @return Success<T>
 */
function Success(mixed $value): Success
{
    return Success::pure($value);
}

/**
 * @return Failure<mixed>
 */
function Failure(Reason $reason): Failure
{
    return Failure::because($reason);
}

function Because(string $reason): Because
{
    return Because::of($reason);
}

function BecauseException(Exception $exception): BecauseException
{
    return BecauseException::of($exception);
}

function BecauseNull(): BecauseNull
{
    return BecauseNull::create();
}

/**
 * @template T
 * @param callable():T $fn
 * @return Either<T>
 */
function DoTry(callable $fn): Either
{
    return Either::try($fn);
}