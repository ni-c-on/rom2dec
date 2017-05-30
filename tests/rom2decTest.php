<?php

namespace rom2dec\tests;

use PHPUnit\Framework\TestCase;
use rom2dec\rom2dec;

class Rom2DecTest extends TestCase
{
    public function numbersProvider()
    {
        return [
            ['i', 1],
            ['ii', 2],
            ['iv', 4],
            ['v', 5],
            ['vi', 6],
            ['ix', 9],
            ['x', 10],
            ['xi', 11],
            ['xlii', 42],
            ['xl', 40],
            ['l', 50],
            ['lx', 60],
            ['xc', 90],
            ['c', 100],
            ['cx', 110],
            ['cd', 400],
            ['d', 500],
            ['dc', 600],
            ['m', 1000],
            ['mm', 2000],
            ['mcmlxxxiv', 1984],
        ];
    }

    /**
     * @dataProvider numbersProvider
     */
    public function testConvertSimpleNumbers($rom, $dec)
    {
        $this->assertEquals($dec, rom2dec::convert($rom));
    }

    public function testCaseInsensitive()
    {
        $this->assertEquals(1984, rom2dec::convert('MCMLXXXIV'));
        $this->assertEquals(1984, rom2dec::convert('mcmlxxxiv'));
        $this->assertEquals(1984, rom2dec::convert('MCMlxxxiv'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgument()
    {
        rom2dec::convert('abc');
    }

    public function invalidSequencesProvider()
    {
        return [
            ['iiii'], ['iiv'], ['iix'], ['il'], ['ic'], ['im'],
            ['vv'], ['vx'], ['vl'], ['vc'], ['vd'], ['vm'],
            ['xxxx'], ['xxl'], ['xxc'], ['xd'], ['xm'],
            ['ll'], ['lc'], ['ld'], ['lm'],
            ['cccc'], ['ccd'], ['ccm'],
            ['dddd'], ['ddm'],
        ];
    }

    /**
     * @dataProvider invalidSequencesProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidSequences($rom)
    {
        rom2dec::convert($rom);
    }
}
