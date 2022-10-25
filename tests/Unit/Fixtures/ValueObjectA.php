<?php

namespace j45l\functional\Test\Unit\Fixtures;

class ValueObjectA
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getA(): string
    {
        return $this->value;
    }
}
