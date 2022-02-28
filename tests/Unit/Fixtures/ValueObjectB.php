<?php

namespace j45l\functional\Test\Unit\Fixtures;

class ValueObjectB
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getB(): string
    {
        return $this->value;
    }
}
