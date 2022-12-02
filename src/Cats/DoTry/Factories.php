<?php

declare(strict_types=1);

namespace j45l\functional\Cats\DoTry;

use Exception;
use j45l\functional\Cats\DoTry\Reason\Because;
use j45l\functional\Cats\DoTry\Reason\BecauseException;
use j45l\functional\Cats\DoTry\Reason\BecauseNull;
use j45l\functional\Cats\DoTry\Reason\Reason;

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
 * @return DoTry<T>
 */
function DoTry(callable $fn): DoTry
{
    return DoTry::try($fn);
}