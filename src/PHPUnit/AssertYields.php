<?php

declare(strict_types=1);

namespace j45l\functional\PHPUnit;

use Closure;
use Generator;
use PHPUnit\Framework\ExpectationFailedException;

use function j45l\functional\also;
use function PHPUnit\Framework\assertEquals;

function assertYields(Generator $expected, Generator $actual): void
{
    $wrapAssert = static function (Closure $fn, $message) {
        try {
            $fn();
        } catch (ExpectationFailedException $expectationFailedException) {
            throw new ExpectationFailedException(
                str_replace('%', $expectationFailedException->getMessage(), $message),
                $expectationFailedException->getComparisonFailure(),
                $expectationFailedException
            );
        }
    };

    $nth = static fn (int $ordinal) => sprintf(
        '%d%s',
        $ordinal,
        match (true) {
            $ordinal % 10 === 1 => 'st',
            $ordinal % 10 === 2 => 'nd',
            $ordinal % 10 === 3 => 'rd',
            default => 'th'
        }
    );

    $ordinal = 1;
    while (match (true) {
        !$expected->valid() && !$actual->valid() => false,
        !$expected->valid() =>
        throw new ExpectationFailedException('Expected generator exhausted before actual.'),
        !$actual->valid() =>
        throw new ExpectationFailedException('Actual generator exhausted before expected.'),
        default => also(function () use ($expected, $actual, $wrapAssert, $nth, $ordinal): void {
            $wrapAssert(
                fn () => assertEquals($expected->key(), $actual->key()),
                sprintf('%s generated keys are not equal <%%>.', $nth($ordinal)),
            );
            $wrapAssert(
                fn () => assertEquals($expected->current(), $actual->current()),
                sprintf('%s generated values are not equal <%%>.', $nth($ordinal)),
            );
            $expected->next();
            $actual->next();
        })(true),
    }) {
        $ordinal++;
    }

    $wrapAssert(fn () => assertEquals($expected, $actual), 'Return values are different <%s>.');
}
