<?php

declare(strict_types=1);

namespace j45l\functional\Sequences;

interface Sequence
{
    /** @return mixed */
    public function value();

    public function next(): Sequence;
}
