<?php

namespace j45l\functional\Test\Unit\Fixtures;

class ValueObjectB
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getB(): string
    {
        return $this->value;
    }
}
