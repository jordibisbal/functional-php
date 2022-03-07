<?php

namespace j45l\functional;

interface Functor
{
    public function map(callable $closure): Functor;
}
