<?php

declare(strict_types=1);

namespace App\Tests\Unit\Operation;

use App\Operation\SingularPathSegmentNameGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Operation\SingularPathSegmentNameGenerator
 */
class SingularPathSegmentNameGeneratorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test($name, $expected): void
    {
        $generator = new SingularPathSegmentNameGenerator();
        $this->assertEquals($expected, $generator->getSegmentName($name));
    }

    /**
     * Create a shortened URL repository mock.
     */
    public function dataProvider(): array
    {
        return [
            ['', ''],
            ['simple', 'simple'],
            ['Simple', 'simple'],
            ['MoreAdvanced', 'more-advanced'],
            ['EvenMore123Sophisticat3d', 'even-more123-sophisticat3d'],
            ['ABBREV', 'a-b-b-r-e-v'],
        ];
    }
}
