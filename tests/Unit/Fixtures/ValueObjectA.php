<?php

namespace j45l\functional\Test\Unit\Fixtures;

class ValueObjectA
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getA(): string
    {
        return $this->value;
    }
}
