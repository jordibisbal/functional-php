<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

use function array_shift as arrayShift;

/** @return Closure */
function tailRecursion(Closure $recursiveFn): Closure
{
    $underCall = false;
    $queue = [];

    return static function (...$args) use (&$recursiveFn, &$underCall, &$queue) {
        $result = null;
        $queue[] = $args;
        /** @phpstan-ignore-next-line */
        if (!$underCall) {
            $underCall = true;
            while ($head = arrayShift($queue)) {
                $result = $recursiveFn(...$head);
            }
            $underCall = false;
        }
        return $result;
    };
}
