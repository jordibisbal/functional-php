<?php

declare(strict_types=1);

namespace j45l\functional;

interface Functor
{
    public function map(callable $callable): Functor;
}
