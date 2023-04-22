<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\unzip;
use function j45l\functional\zip;

#[CoversFunction('j45l\functional\zip')]
class ZipTest extends TestCase
{
    public function testUnzipArray(): void
    {
        $this->assertEquals(
            [[1, 'a'], [2, 'b'],  [3, 'c']],
            zip([[1, 2, 3], ['a', 'b', 'c']]),
        );
    }

    public function testUnzipRightHasDefaultValue(): void
    {
        $this->assertEquals(
            [[1, 2, 3], ['a', 'b', 'default']],
            unzip([[1, 'a'], [2, 'b'],  [3]], 'default')
        );
    }

    public function testUnzipLeftHasDefaultValue(): void
    {
        $this->assertEquals(
            [[1, 2, 'left'], ['a', 'b', 'right']],
            unzip([[1, 'a'], [2, 'b'], null], 'left', 'right')
        );
    }
}
