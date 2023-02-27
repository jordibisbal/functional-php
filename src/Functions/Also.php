<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T
 * @param Closure(T):mixed $function
 * @return Closure(T):T
 */
function also(Closure $function): Closure
{
    return static function ($x) use ($function) {
        $function($x);

        return $x;
    };
}
