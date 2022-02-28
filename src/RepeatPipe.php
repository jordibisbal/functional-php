<?php

namespace j45l\functional;

use Closure;

use function Functional\tail_recursion;

/**
 * @phpstan-return Closure(int): (Closure(mixed): mixed)
 */
function repeatPipe(Closure $map): Closure
{
    $doMap = tail_recursion(
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
