<?php

namespace j45l\functional\Test\Unit\Fixtures;

class ValueObjectC
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getC(): string
    {
        return $this->value;
    }
}
