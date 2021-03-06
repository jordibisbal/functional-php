<?php

declare(strict_types=1);

namespace j45l\functional;

interface Functor
{
    /**
     * @return Functor
     */
    public function map(callable $function): Functor;
}
