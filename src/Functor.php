<?php

namespace j45l\functional;

use Closure;

interface Functor
{
    public function map(Closure $closure): Functor;
}
