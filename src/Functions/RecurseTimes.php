<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T
 * @param Closure(T):T $map
 * @phpstan-return Closure(int): (Closure(mixed): mixed)
 */
function recurseTimes(Closure $map): Closure
{
    $doMap = tailRecursion(
        static function ($initial, $times) use ($map, &$doMap) {
            if ($times < 1) {
                return $initial;
            }

            /**
             * @phpstan-var Closure $doMap
             */
            return $doMap($map($initial), $times - 1);
        }
    );

    return static function (int $times) use ($doMap) {
        return static function ($initial) use ($times, $doMap) {
            return $doMap($initial, $times);
        };
    };
}
